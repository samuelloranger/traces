<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use App\ConnexionBD;
use \PDO;

class Auteur{
    //Attributs
    private $pdo = null;
    private $id = 0;
    private $nom = "";
    private $prenom = "";
    private $biographie = "";
    private $url_blogue = "";

    public function __construct(){

    }

    public static function trouverTout():array{
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM auteurs";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Auteur::class);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrAuteurs = $requetePreparee -> fetchAll();

        return $arrAuteurs;
    }

    public static function trouverAuteurLivre($idLivre){
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM auteurs INNER JOIN auteurs_livres ON auteurs.id = auteurs_livres.auteur_id WHERE livre_id = :idLivre";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Auteur::class);

        //On bind le paramètre idAueur
        $requetePreparee -> bindParam(":idLivre", $idLivre, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrAuteur = $requetePreparee -> fetchAll();

        return $arrAuteur;
    }

    public static function trouverAuteurActualite(int $idAuteur): Auteur {
        $pdo = App::getInstance()->getPDO();

        $chaine = "SELECT * FROM auteurs INNER JOIN actualites ON auteurs.id = actualites.id_auteur WHERE actualites.id_auteur = :idAuteur";

        $requete = $pdo->prepare($chaine);
        $requete->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $requete->bindParam(":idAuteur", $idAuteur, PDO::PARAM_INT);
        $requete->execute();

        $auteur = $requete->fetch();

        return $auteur;
    }

    public function getNomPrenom(): string {
        return $this -> prenom . " " . $this -> nom;
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
