<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use App\ConnexionBD;
use \PDO;

class Categories{
    //Attributs
    private $pdo = null;
    public $id = "";
    public $nom_fr = "";
    public $nom_en = "";

    public function __construct(){

    }

    public static function trouverTout():array{
        $pdo = App::getInstance() -> getPDO();

        //Requête SQL
        $sql = "SELECT * FROM categories";

        //On prépare la requête
        $requetePreparee = $pdo -> prepare($sql);

        // Définir le mode de récupération
        $requetePreparee -> setFetchMode(PDO::FETCH_CLASS, Categories::class);

        // Exécuter la requête
        $requetePreparee -> execute();

        // Récupérer une seule occurrence à la fois
        $arrCategories = $requetePreparee -> fetchAll();

        return $arrCategories;
    }

}
?>
