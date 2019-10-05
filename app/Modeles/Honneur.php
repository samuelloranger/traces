<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Honneur{
    //Attributs
    private $pdo = null;
    private $id = 0;
    private $nom = "";
    private $description = "";

    public function __construct(){

    }

    public static function trouverHonneursLivre($idLivre){
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM honneurs INNER JOIN honneurs_livres ON honneurs.id = honneurs_livres.honneur_id WHERE livre_id = :idLivre";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Honneur::class);

        //On bind le paramètre idAueur
        $requetePreparee -> bindParam(":idLivre", $idLivre, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrHonneurs = $requetePreparee -> fetchAll();

        return $arrHonneurs;
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