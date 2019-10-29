<?php

declare(strict_types=1);

namespace App\Modeles;

use App\App;
use \PDO;
use App\Util;

class User {
    //Attributs
    private $id;
    private $prenom;
    private $nom;
    private $courriel;
    private $telephone;
    private $mot_de_passe;

    public function __construct()
    {
    }

    public static function trouverParCourriel(string $courriel): User {
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

    public static function insererUser(string $prenom, string $nom, string $courriel, string $mot_de_passe) {
//        if (User::trouverParCourriel($courriel) !== null) {
//            return;
//        }
        //Importation de l'objet PDO
        $pdo = App::getInstance()->getPDO();
        //Construction de la chaine de requete
        $chaineRequete = "INSERT INTO t_client (prenom, nom, courriel, telephone, mot_de_passe) 
                          VALUES (:prenom, :nom, :courriel, 9999999999, :mot_de_passe)";
        //Preparation de la requete
        $requete = $pdo->prepare($chaineRequete);
        //Attachement des valeurs personnalisees
        $requete->bindValue(":prenom", $prenom, PDO::PARAM_STR);
        $requete->bindValue(":nom", $nom, PDO::PARAM_STR);
        $requete->bindValue(":courriel", $courriel, PDO::PARAM_STR);
        $requete->bindValue(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
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