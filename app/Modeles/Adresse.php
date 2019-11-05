<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Adresse{
    //Attributs
    private $id = 0;
    private $etat = "";

    public function __construct(){

    }

    public static function trouver($idParution):string{
        $pdo = App::getInstance() -> getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id, etat FROM parutions WHERE id = :idParution";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Parution::class);

        //On bind le paramètre idParution
        $requetePreparee -> bindParam(":idParution", $idParution, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $parution = $requetePreparee -> fetch();

        return $parution -> etat;
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