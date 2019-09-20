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
}
?>