<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use App\ConnexionBD;
use \PDO;

class Categories
{
    //Attributs
    private $pdo = null;
    public $id = "";
    public $nom_fr = "";
    public $nom_en = "";

    public function __construct()
    {

    }

    public static function trouverTout(): array
    {
        $pdo = App::getInstance()->getPDO();

        //Requête SQL
        $sql = "SELECT * FROM categories";

        //On prépare la requête
        $requetePreparee = $pdo->prepare($sql);

        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Categories::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $arrCategories = $requetePreparee->fetchAll();

        return $arrCategories;
    }

    public static function trouverParId($id_categorie): Categories
    {
        $pdo = App::getInstance()->getPDO();

        //Requête SQL
        $sql = "SELECT * FROM categories WHERE id = :id_categorie";

        $requetePreparee = $pdo->prepare($sql);

        $requetePreparee->bindParam(":id_categorie", $id_categorie, PDO::PARAM_INT);
        // Définir le mode de récupération
        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Categories::class);

        // Exécuter la requête
        $requetePreparee->execute();

        // Récupérer une seule occurrence à la fois
        $categorie = $requetePreparee->fetch();

        return $categorie;
    }

}

?>
