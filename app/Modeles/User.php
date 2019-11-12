<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;
use App\Util;

class User {
    //Attributs
    private $id_client;
    private $prenom;
    private $nom;
    private $courriel;
    private $telephone;
    private $mot_de_passe;

    public function __construct()
    {
    }

    public static function trouverParCourriel(string $courriel) {
        $pdo = App::getInstance()->getPDO();

        $chaineRequete = "SELECT * FROM t_client WHERE courriel = :courriel";

        $requete = $pdo->prepare($chaineRequete);

        //Parametres de recuperation
        $requete->setFetchMode(PDO::FETCH_CLASS, User::class);

        //Bind du parametre de courriel
        $requete->bindValue(":courriel", $courriel, PDO::PARAM_STR);

        $requete->execute();
        $user = $requete->fetch();

        return $user;
    }

    public static function trouverParConnexion(string $courriel, string $mdp) {
        //echo password_hash($mdp, PASSWORD_DEFAULT) . "<br>";
        $pdo = App::getInstance()->getPDO();

        $chaineRequete = "SELECT * FROM t_client WHERE courriel = :courriel AND mot_de_passe = :mdp";

        $requete = $pdo->prepare($chaineRequete);

        //Parametres de recuperation
        $requete->setFetchMode(PDO::FETCH_CLASS, User::class);

        //Bind du parametre de courriel
        $requete->bindValue(":courriel", $courriel, PDO::PARAM_STR);
        $requete->bindValue(":mdp", $mdp, PDO::PARAM_STR);

        $requete->execute();
        $user = $requete->fetch();

        return $user;
    }

    public static function getHash(string $courriel) {
        $pdo = App::getInstance()->getPDO();

        $chaineRequete = "SELECT mot_de_passe FROM t_client WHERE courriel = :courriel";

        $requete = $pdo->prepare($chaineRequete);
        $requete->bindValue(":courriel", $courriel, PDO::PARAM_STR);
        $requete->execute();

        $mot_de_passe = $requete->fetch();

        return $mot_de_passe[0];
    }

    public static function insererUser(string $prenom, string $nom, string $courriel, string $mot_de_passe) {
//        if (User::trouverParCourriel($courriel) !== null) {
//            return;
//        }
        $telephone = 9999999;
        //Importation de l'objet PDO
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_client (prenom, nom, courriel, telephone, mot_de_passe) 
                          VALUES (?, ?, ?, ?, ?)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindParam(1, $prenom, PDO::PARAM_STR);
        $requete->bindParam(2, $nom, PDO::PARAM_STR);
        $requete->bindParam(3, $courriel, PDO::PARAM_STR);
        $requete->bindParam(4, $telephone, PDO::PARAM_INT);
        $requete->bindParam(5, $mot_de_passe, PDO::PARAM_STR);
        //Execution de la requete
        $requete->execute();
    }

    /**
     * Fonction __get
     * @param $property mixed La propriete recherche
     * @return mixed Retourne la valeur recherche
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * Fonction __set
     * @param $property mixed La propriete a changer
     * @param $value mixed La nouvelle valeur de la propriete a changer
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}