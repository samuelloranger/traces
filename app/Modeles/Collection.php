<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Collection{
    //Attributs
    private $pdo = null;
    private $id = 0;
    private $nom = "";
    private $description = "";

    public function __construct(){

    }

    public static function trouverParId($idCollection):Collection{
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM collections WHERE collections.id = :idCollection";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Collection::class);

        //On bind le paramètre idAueur
        $requetePreparee -> bindParam(":idCollection", $idCollection, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $collection = $requetePreparee -> fetch();

        return $collection;
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