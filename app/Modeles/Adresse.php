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

    public static function trouverProvince(string $abbrProvince)
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT nom FROM t_province WHERE abbr_province = :abbr";

        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        // Définir le mode de récupération
        //$requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        $requetePreparee->bindValue(":abbr", $abbrProvince, PDO::PARAM_STR);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $strProvince = $requetePreparee->fetch();

        return $strProvince[0];

    }

    public static function trouverIdClient(string $courriel): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_client FROM t_client WHERE courriel = :courriel";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        $requetePreparee->bindValue(":courriel", $courriel, PDO::PARAM_STR);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdClient = $requetePreparee->fetchAll();

        return $intIdClient;
    }

    public static function trouverIdAdresseLivraison(int $idClient): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_adresse FROM t_adresse WHERE t_adresse.id_client = :idClient AND t_adresse.type = 'livraison'";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        $requetePreparee->bindValue(":idClient", $idClient, PDO::PARAM_INT);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdAdresseLivraison = $requetePreparee->fetchAll();

        return $intIdAdresseLivraison;
    }

    public static function trouverIdAdresseFacturation(int $idClient): array
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_adresse FROM t_adresse WHERE t_adresse.id_client = :idClient AND t_adresse.type = 'facturation'";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Adresse::class);
        $requetePreparee->bindValue(":idClient", $idClient, PDO::PARAM_INT);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdAdresseFacturation = $requetePreparee->fetchAll();

        return $intIdAdresseFacturation;
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