<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;
use App\Util;

class Livre
{
    //Attributs
    private $id = 0;
    private $nbre_pages = 0;
    private $est_illustre = 0;
    private $annee_publication = 0;
    private $langue = "";
    private $prix = 0;
    private $titre = "";
    private $sous_titre = "";
    private $mots_cles = "";
    private $isbn = "";
    private $isbn13 = "";
    private $description = "";
    private $autres_caracteristiques = "";
    private $est_coup_de_coeur = 0;
    private $parution_id = 0;
    private $etat = 0;
    private $collection_id = 0;
    private $pdo = null;

    public function __construct()
    {

    }

    /**
     * Fonction trouverTout
     * @return array Retourne tous les livres
     */
    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $chaineSQL = 'SELECT * FROM livres';

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $arrayLivres = $requetePreparee->fetchAll();

        return $arrayLivres;
    }

    /**
     * Fonction trrouverParIsbn
     * @param string $isbnLivre L'isbn du livre recherche
     * @return Livre Retourne les infos d'un seul livre selon son isbn
     */
    public static function trouverParIsbn(string $isbnLivre): Livre
    {
        $pdo = App::getInstance()->getPDO();

        $requeteSQL = "SELECT * FROM livres WHERE isbn = :isbn";

        $requetePreparee = $pdo->prepare($requeteSQL);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        //Bind du paramètre
        $requetePreparee->bindValue(':isbn', $isbnLivre, PDO::PARAM_STR);

        $requetePreparee->execute();

        $livre = $requetePreparee->fetch();

        return $livre;
    }

    /**
     * Fonction trouverParLimite
     * @param int $unIndex L'index de debut de la recherche
     * @param int $uneQte La quantite a rechercher
     * @param int $categorie L'id de la cateogie
     * @param string $trierPar Type de tri
     * @return array Retourne un array de livres filtre
     */
    public static function trouverParLimite(int $unIndex, int $uneQte, int $categorie, string $trierPar): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $triChaine = "";
        if ($trierPar != "") {
            if ($trierPar == "alphabetique") {
                $triChaine = ' ORDER BY livres.titre ASC';
            }
            if ($trierPar == "prixCroissant") {
                $triChaine = ' ORDER BY livres.prix ASC';
            }
            if ($trierPar == "prixDecroissant") {
                $triChaine = ' ORDER BY livres.prix DESC';
            }
        }

        $chaineCategorie = "";
        if ($categorie !== 0) {
            $chaineCategorie = " INNER JOIN categories_livres ON categories_livres.livre_id = livres.id WHERE categorie_id= :categorie";
        }

        $limite = " LIMIT :unIndex, :uneQte";

        $chaineSQL = 'SELECT * FROM livres' . $chaineCategorie . $triChaine . $limite;

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($chaineSQL);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        //Bind des paramètres
        if ($unIndex > 0) {
            $unIndex = $unIndex * $uneQte;
        } else {
            $unIndex = 0;
        }

        $requetePreparee->bindParam(":unIndex", $unIndex, PDO::PARAM_INT);
        $requetePreparee->bindParam(":uneQte", $uneQte, PDO::PARAM_INT);
        if ($categorie != 0) {
            $requetePreparee->bindParam(":categorie", $categorie, PDO::PARAM_INT);
        }

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $arrayLivres = $requetePreparee->fetchAll();

        return $arrayLivres;
    }

    /**
     * Fonction compter
     * @param int $categorie l'id de la categorie
     * @return int Retourne un compte du nombre de livres total affiches
     */
    public static function compter(int $categorie): int
    {
        //On va chercher le pdo
        $pdo = App::getInstance()->getPDO();

        //Requête SQL

        if ($categorie != 0) {
            $sql = 'SELECT COUNT(livres.id) FROM livres INNER JOIN categories_livres ON livres.id = categories_livres.livre_id WHERE categorie_id= :categorie';
        } else {
            $sql = "SELECT COUNT(*) FROM livres";
        }

        //On prépare la requête
        $requetePreparee = $pdo->prepare($sql);

        if ($categorie != 0) {
            $requetePreparee->bindParam(":categorie", $categorie, PDO::PARAM_INT);
        }

        //On éxécute la requête
        $requetePreparee->execute();

        //Définition de la variables
        $nbrLivre = $requetePreparee->fetch();

        return (int)$nbrLivre[0];
    }

    /**
     * Fonction getCoupsCoeurs
     * @return array Retourne un tableau des livres qui font partie des coups de coeur
     */
    public static function getCoupsCoeur(): array
    {
        $pdo = App::getInstance()->getPDO();
        $chaineRequete = "SELECT * FROM livres WHERE est_coup_de_coeur = 1";

        $requete = $pdo->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        $requete->execute();

        $arrCoupsCoeur = $requete->fetchAll();

        return $arrCoupsCoeur;
    }

    /**
     * Fonction
     * @return array Retourne les livres dont la parution est de type 3 (nouveutees)
     */
    public static function getNouveautes(): array
    {
        $pdo = App::getInstance()->getPDO();
        $chaineRequete = "SELECT *
                          FROM livres  
                          WHERE parution_id = 3";

        $requete = $pdo->prepare($chaineRequete);

        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        $requete->execute();

        $arrNouveautes = $requete->fetchAll();

        return $arrNouveautes;
    }

    /**
     * Fonction getCategorieLivre
     * @return array Retourne le id et le nom de la categorie du livre
     */
    public function getInfosCategorieLivre():array{
        $pdo = App::getInstance()->getPDO();

        $sql = "SELECT categories.id, nom_fr FROM categories INNER JOIN categories_livres ON categories_livres.categorie_id = categories.id WHERE categories_livres.livre_id = :livreId";

        $requetePreparee = $pdo->prepare($sql);

        $requetePreparee->bindParam(":livreId", $this->id, PDO::PARAM_INT);

        $requetePreparee->execute();

        return $requetePreparee->fetch();
    }

    /**
     * Fonction getParution
     * @return string retourne le type de parution
     */
    public function getParution(): string
    {
        return Parution::trouver($this->parution_id);
    }

    /**
     * Fonction getAuteurs
     * @return array Retourne un array des noms des auteurs
     */
    public function getAuteurs(): array
    {
        return Auteur::trouverAuteurLivre($this->id);
    }

    /**
     * Fonction getHonneurs
     * @return array Retourne un array des Honneurs
     */
    public function getHonneurs(): array
    {
        return Honneur::trouverHonneursLivre($this->id);
    }

    /**
     * Fonction getPrix
     * @return string Retourne le prix du livre formate
     */
    public function getPrix():string{
        return Util::formaterArgent(floatval($this->prix));
    }

    /**
     * Fonction getImageUrl
     * @param string $format le format entre desire, par defaut "rectangle"
     * @return string Retourne l'url de l'image
     */
    public function getImageUrl($format = "rectangle"): string{

        if ($format === "carre") {
            $url = "liaisons/images/couvertures-livres/L" . Util::ISBNToEAN($this->isbn) . "1_carre.jpg";
        } else {
            $url = "liaisons/images/couvertures-livres/L" . Util::ISBNToEAN($this->isbn) . "1.jpg";
        }

        if (!file_exists($url)) {
            if ($format !== "carre") {
                $url = " ./liaisons/images/couvertures-livres/imageNonTrouvee.svg";
            } else {
                $url = " ./liaisons/images/couvertures-livres/imageNonTrouvee_carre.svg";
            }
        }

        return "$url";
    }

    /**
     * Fonction getDescriptionNettoyee
     * @return string Retourne la description du livre coupee
     */
    public function getDescriptionNettoyee(): string
    {
        return Util::couperParagraphe($this->description, 300);
    }

    /**
     * Fonction __get
     * @param $property mixed La propriete recherche
     * @return mixed Retourne la valeur recherche
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * Fonction __set
     * @param $property mixed La propriete a changer
     * @param $value mixed La nouvelle valeur de la propriete a changer
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }


}
