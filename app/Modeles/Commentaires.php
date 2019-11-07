<?php

declare(strict_types=1);
namespace App\Modeles;

use App\App;
use \PDO;

class Commentaires{
    private $id_commentaire = null;
    private $id_client = 0;
    private $prenom = "";
    private $nom = "";
    private $isbn_livre = "";
    private $titre_commentaire = "";
    private $texte_commentaire = "";
    private $cote = 0;
    private $achat_verifie = 0;

    public function __construct(){
    }

    public static function trouverTout():array{
        $pdo = App::getInstance()->getPDO();

        $requeteSQL = "SELECT id_commentaire, commentaires.id_client, prenom, nom, isbn_livre, titre_commentaire, texte_commentaire, cote, achat_verifie
                       FROM commentaires 
                       INNER JOIN t_client ON t_client.id_client = commentaires.id_client";

        $requetePreparee = $pdo -> prepare($requeteSQL);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Commentaires::class);

        $requetePreparee->execute();

        return $requetePreparee->fetchAll();
    }

    public static function trouverParISBN(string $isbn):array{
        $pdo = App::getInstance()->getPDO();

        $requeteSQL = "SELECT id_commentaire, commentaires.id_client, prenom, nom, isbn_livre, titre_commentaire, texte_commentaire, cote, achat_verifie
                       FROM commentaires 
                       INNER JOIN t_client ON t_client.id_client = commentaires.id_client
                       WHERE isbn_livre = :isbn";

        $requetePreparee = $pdo -> prepare($requeteSQL);

        $requetePreparee->setFetchMode(PDO::FETCH_CLASS, Commentaires::class);

        $requetePreparee->bindValue(':isbn', $isbn, PDO::PARAM_STR);

//        try{
            $requetePreparee->execute();
//        }
//        catch(\Exception $erreur){
//            error_log($erreur->getTraceAsString() . "\n", 3, "../ressources/error_log.txt");
//        }

        return $requetePreparee->fetchAll();
    }

    public static function insererCommentaire(int $id_client, string $isbn_livre, string $titre_commentaire, string $texte_commentaire, int $cote, int $achat_verifie){
        $pdo = App::getInstance()->getPDO();

        $requeteSQL = "INSERT INTO commentaires (id_client, isbn_livre, titre_commentaire, texte_commentaire, cote, achat_verifie) VALUES(?, ?, ?, ?, ?, ?)";

        $requetePreparee = $pdo->prepare($requeteSQL);

        $requetePreparee->bindValue(1, $id_client, PDO::PARAM_INT);
        $requetePreparee->bindValue(2, $isbn_livre, PDO::PARAM_STR);
        $requetePreparee->bindValue(3, $titre_commentaire, PDO::PARAM_STR);
        $requetePreparee->bindValue(4, $texte_commentaire, PDO::PARAM_STR);
        $requetePreparee->bindValue(5, $cote, PDO::PARAM_INT);
        $requetePreparee->bindValue(6, $achat_verifie, PDO::PARAM_INT);

        try{
            $requetePreparee->execute();
        }
        catch(\Exception $error){
            error_log($error->getTraceAsString() . "\n", 3, "../ressources/error_log.txt");
        }
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