<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use App\Util;
use \PDO;

class Actualite {
    private $id;
    private $date;
    private $titre;
    private $texte;
    private $id_auteur;

    public function __construct() {

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

    public static function trouverTout(): array {
        $pdo = App::getInstance()->getPDO();

        $chaineSQL = "SELECT * FROM actualites";

        $requete = $pdo->prepare($chaineSQL);
        $requete->setFetchMode(PDO::FETCH_CLASS, Actualite::class);
        $requete->execute();

        $arrActualites = $requete->fetchAll();

        return $arrActualites;
    }

    public function getAuteur(): Auteur {
        return Auteur::trouverAuteurActualite((int)$this->id_auteur);
    }

    public function getTexteClean(): string {
        return strip_tags($this->texte);
    }

    public function getTexteTronque() {
        return Util::couperParagraphe($this->texte, 800);
    }
}