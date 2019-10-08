<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Recension{
    //Attributs
    private $pdo = null;
    private $id = 0;
    private $date = "";
    private $titre = "";
    private $nom_media = "";
    private $nom_journaliste = "";
    private $description = "";
    private $livre_id = "";

    public function __construct(){

    }

    public static function trouverRecensions($idLivre){
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM recensions WHERE livre_id = :idLivre LIMIT 2";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Recension::class);

        //On bind le paramètre idAueur
        $requetePreparee -> bindParam(":idLivre", $idLivre, PDO::PARAM_INT);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrRecensions = $requetePreparee -> fetchAll();

        shuffle($arrRecensions);

        return $arrRecensions;
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
