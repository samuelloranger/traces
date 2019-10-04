<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Livre{
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
    private $description = "";
    private $autres_caracteristiques = "";
    private $est_coup_de_coeur = 0;
    private $parution_id = 0;
    private $etat = 0;
    private $collection_id = 0;
    private $pdo = null;

    public function __construct(){

    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this -> $property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this -> $property = $value;
        }
    }

    public static function trouverTout():array{
        $pdo = App::getInstance() -> getPDO();

        // Définir la chaine SQL
        $chaineSQL = 'SELECT livres.id, titre, nbre_pages, parution_id FROM livres';

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo -> prepare($chaineSQL);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Livre::class);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrayLivres = $requetePreparee->fetchAll();

        return $arrayLivres;
    }

    public static function compter():int{
        //On va chercher le pdo
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT COUNT(*) FROM livres";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        //On éxécute la requête
        $requetePreparee -> execute();

        //Définition de la variable
        $nbrLivre = $requetePreparee -> fetch();

        //On retourne nbrLivres de type int, à la valeur 0 puisque
        //$nbrLivre est
        return (int)$nbrLivre[0];
    }

    /**
     * Va chercher les infos d'un seul livre
     * @param int $idLivre ID du livre recherche
     */
    public static function trouverParId(int $id):Livre{
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM livres WHERE id = :id";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Livre::class);

        // On bind le paramètre id
        $requetePreparee -> bindParam(":id", $id, PDO::PARAM_INT);

        //On éxécute la requête
        $requetePreparee -> execute();

        //Définition de la variable
        $infosLivre = $requetePreparee -> fetch();

        return $infosLivre;
    }

    public static function trouverParLimite(int $unIndex, int $uneQte):array{
        $pdo = App::getInstance() -> getPDO();

        // Définir la chaine SQL
        $chaineSQL = 'SELECT * FROM livres LIMIT :unIndex, :uneQte';

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo -> prepare($chaineSQL);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Livre::class);

        //Bind des paramètres
        if($unIndex > 0){
            $unIndex = $unIndex * $uneQte;
        }
        else{
            $unIndex = 0;
        }

        $requetePreparee -> bindParam(":unIndex", $unIndex, PDO::PARAM_INT);
        $requetePreparee -> bindParam(":uneQte", $uneQte, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrayLivres = $requetePreparee->fetchAll();

        return $arrayLivres;
    }

    public function getParution():string{
        return Parution::trouver($this -> parution_id);
    }

    public function getAuteurs():array{
        return Auteur::trouverAuteurLivre($this -> id);
    }

    public function getImageUrl():string{
        return "../public/liaisons/images/couvertures-livres/L" . Livre::ISBNToEAN($this -> isbn) . ".jpg";
    }

    public function getDescriptionNettoyee():string{
        return strip_tags($this -> description);
    }

    public static function getCoupsCoeur(): array {
        $pdo = App::getInstance()->getPDO();
        $chaineRequete = "SELECT *
                          FROM livres  
                          WHERE est_coup_de_coeur = 1";

        $requete = $pdo->prepare($chaineRequete);
        $requete->setFetchMode(PDO::FETCH_CLASS, Livre::class);

        $requete->execute();

        $arrCoupsCoeur = $requete->fetchAll();

        return $arrCoupsCoeur;
    }

    /*
    * @method ISBNToEAN
    * @desc Convertit un ISBN en format EAN
    * @param string - ISBN à convertir
    * @return string - ISBN converti en EAN, ou FALSE si erreur dans le format ou la conversion
    */
    public static function ISBNToEAN ($strISBN){
        $myFirstPart = $mySecondPart = $myEan = $myTotal = "";
        if ($strISBN == "")
            return false;
        $strISBN = str_replace("-", "", $strISBN);
        // ISBN-10
        if (strlen($strISBN) == 10)
        {
            $myEan = "978" . substr($strISBN, 0, 9);
            $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));
            $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));
            $tmp = intval(substr((3 * $myFirstPart + $mySecondPart), -1));
            $myControl = ($tmp == 0) ? 0 : 10 - $tmp;

            return $myEan . $myControl;
        }
        // ISBN-13
        else if (strlen($strISBN) == 13) return $strISBN;
        // Autre
        else return false;
    }
}
