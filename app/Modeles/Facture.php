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
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Facture::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $arrModePaiement = $requetePreparee->fetchAll();

        return $arrModePaiement;
    }

    public static function insererModePaiement(int $estPaypal, string $nomComplet, string $noCarte, string $typeCarte, string $dateExpirationCarte, int $code, int $estDefaut, int $idClient)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_mode_paiement(est_paypal, nom_complet, no_carte, type_carte, date_expiration_carte, code, est_defaut, id_client) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $estPaypal, PDO::PARAM_INT);
        $requete->bindParam(2, $nomComplet, PDO::PARAM_STR);
        $requete->bindParam(3, $noCarte, PDO::PARAM_STR);
        $requete->bindParam(4, $typeCarte, PDO::PARAM_STR);
        $requete->bindParam(5, $dateExpirationCarte, PDO::PARAM_STR);
        $requete->bindParam(6, $code, PDO::PARAM_INT);
        $requete->bindParam(7, $estDefaut, PDO::PARAM_INT);
        $requete->bindParam(8, $idClient, PDO::PARAM_INT);

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