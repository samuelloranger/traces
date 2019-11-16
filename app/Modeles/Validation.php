<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;

class Validation
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

    public static function trouverPays(string $abbrPays): string
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT * FROM t_pays WHERE abbr_pays =" . $abbrPays;

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
        $sql = "SELECT * FROM t_province WHERE abbr_province =" . $abbrProvince;

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

    public static function insererAdresse(string $prenom, string $nom, string $adresse, string $ville, string $codePostal, int $estDefaut, string $typeAdresse, string $abbrProvince, int $idClient)
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
        $requete->bindParam(9, $idClient, PDO::PARAM_INT);

        //Execution de la requete
        $requete->execute();

    }

    public static function insererMethodePaiement(int $estPaypal, string $nomComplet, int $noCarte, string $typeCarte, string $dateExpirationCarte, int $code, int $estDefaut, int $idClient)
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
        $requete->bindParam(3, $noCarte, PDO::PARAM_INT);
        $requete->bindParam(4, $typeCarte, PDO::PARAM_STR);
        $requete->bindParam(5, $dateExpirationCarte, PDO::PARAM_STR);
        $requete->bindParam(6, $code, PDO::PARAM_INT);
        $requete->bindParam(7, $estDefaut, PDO::PARAM_INT);
        $requete->bindParam(8, $idClient, PDO::PARAM_INT);
        //Execution de la requete
        $requete->execute();
    }

    public static function insererModeLivraison(string $dateEstimee, string $modeLivraison, int $idClient)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_mode_livraison(date_estimee, mode_livraison, id_client) 
                          VALUES (?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $dateEstimee, PDO::PARAM_STR);
        $requete->bindParam(2, $modeLivraison, PDO::PARAM_STR);
        $requete->bindParam(3, $idClient, PDO::PARAM_INT);

        //Execution de la requete
        $requete->execute();
    }

    public static function insererCommande(string $date, string $courriel, int $idClient, int $idAdresseLivraison, int $idAdresseFacturation, int $idModePaiement, int $idModeLivraison)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_commande(date, courriel, id_client, id_adresse_livraison, id_adresse_facturation, id_mode_paiement, id_mode_livraison) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $date, PDO::PARAM_STR);
        $requete->bindParam(2, $courriel, PDO::PARAM_STR);
        $requete->bindParam(3, $idClient, PDO::PARAM_INT);
        $requete->bindParam(4, $idAdresseLivraison, PDO::PARAM_INT);
        $requete->bindParam(5, $idAdresseFacturation, PDO::PARAM_INT);
        $requete->bindParam(6, $idModePaiement, PDO::PARAM_INT);
        $requete->bindParam(7, $idModeLivraison, PDO::PARAM_INT);

        //Execution de la requete
        $requete->execute();
    }

    public static function insererLigneCommande(string $isbn, float $prix, int $quantite, int $idCommande)
    {
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_ligne_commande(isbn, prix, quantite, id_commande) 
                          VALUES (?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $isbn, PDO::PARAM_STR);
        $requete->bindParam(2, $prix, PDO::PARAM_STR);
        $requete->bindParam(3, $quantite, PDO::PARAM_INT);
        $requete->bindParam(4, $idCommande, PDO::PARAM_INT);

        //Execution de la requete
        $requete->execute();
    }

    public static function trouverIdModePaiement(int $idClient): int
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_mode_paiement FROM t_mode_paiement WHERE t_mode_paiement.id_client = :idClient";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        $requetePreparee->bindValue(":idClient", $idClient, PDO::PARAM_INT);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdModePaiement = $requetePreparee->fetch();

        return intval($intIdModePaiement[0]);
    }

    public static function trouverIdModeLivraison(int $idClient): int
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_mode_livraison FROM t_mode_livraison WHERE t_mode_livraison.id_client = :idClient";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        $requetePreparee->bindValue(":idClient", $idClient, PDO::PARAM_INT);
        // Exécuter la requête
        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdModeLivraison = $requetePreparee->fetch();

        return intval($intIdModeLivraison[0]);
    }

    public static function trouverIdCommande(): int
    {
        $pdo = App::getInstance()->getPDO();

        // Définir la chaine SQL
        $sql = "SELECT id_commande FROM t_commande ORDER BY id_commande";
        // Préparer la requête (optimisation)
        $requetePreparee = $pdo->prepare($sql);

        $requetePreparee->execute();
        // Récupérer une seule occurrence à la fois
        $intIdCommande = $requetePreparee->fetch();

        return intval($intIdCommande[0]);
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