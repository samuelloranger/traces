<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Adresse
{
    //Attributs
    private $id = 0;

    public function __construct()
    {

    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT * FROM t_adresse";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $arrAdresse = $requetePreparee->fetchAll();

        return $arrAdresse;
    }

    public static function insererAdresse(string $prenom, string $nom, string $adresse, string $ville, string $codePostal, boolean $estDefaut, string $typeAdresse, string $abbrProvince)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_adresse(prenom, nom, adresse, ville, codePostal, estDefaut, typeAdresse, abbrProvince) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $prenom, PDO::PARAM_STR);
        $requete->bindParam(2, $nom, PDO::PARAM_STR);
        $requete->bindParam(3, $adresse, PDO::PARAM_STR);
        $requete->bindParam(4, $ville, PDO::PARAM_STR);
        $requete->bindParam(5, $codePostal, PDO::PARAM_STR);
        $requete->bindParam(6, $estDefaut, PDO::PARAM_BOOL);
        $requete->bindParam(7, $typeAdresse, PDO::PARAM_STR);
        $requete->bindParam(8, $abbrProvince, PDO::PARAM_STR);

        //Execution de la requete
        $requete->execute();

    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}

?>