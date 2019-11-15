<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Editeur{
    //Attributs
    private $pdo = null;
    private $id = 0;
    private $nom = "";
    private $url = "";

    public function __construct(){

    }

    public static function trouverParId($idLivre):array{
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT editeurs.id, editeurs.nom, url 
                FROM editeurs
                INNER JOIN editeurs_livres ON editeurs_livres.editeur_id = editeurs.id 
                INNER JOIN livres ON editeurs_livres.livre_id = livres.id 
                WHERE livre_id = :idLivre";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Editeur::class);

        //On bind le paramètre idAueur
        $requetePreparee -> bindParam(":idLivre", $idLivre, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $editeur = $requetePreparee -> fetchAll();

        return $editeur;
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