<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Facture
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
        $sql = "SELECT * FROM t_mode_paiement";

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

    public static function trouverPays(string $abbrPays): string
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT * FROM t_pays WHERE abbr_pays =". $abbrPays;

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $strPays = $requetePreparee->fetch();

        return $strPays;
    }

    public static function trouverProvince(string $abbrProvince): string
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT * FROM t_province WHERE abbr_province =". $abbrProvince;

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $strPays = $requetePreparee->fetch();

        return $strPays;

    }

    public static function insererAdresse(string $prenom, string $nom, string $adresse, string $ville, string $codePostal, int $estDefaut, string $typeAdresse, string $abbrProvince, int $id_client)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_adresse(prenom, nom, adresse, ville, code_postal, est_defaut, type, abbr_province, id_client) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $prenom, PDO::PARAM_STR);
        $requete->bindParam(2, $nom, PDO::PARAM_STR);
        $requete->bindParam(3, $adresse, PDO::PARAM_STR);
        $requete->bindParam(4, $ville, PDO::PARAM_STR);
        $requete->bindParam(5, $codePostal, PDO::PARAM_STR);
        $requete->bindParam(6, $estDefaut, PDO::PARAM_INT);
        $requete->bindParam(7, $typeAdresse, PDO::PARAM_STR);
        $requete->bindParam(8, $abbrProvince, PDO::PARAM_STR);
        $requete->bindParam(9, $id_client, PDO::PARAM_INT);

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