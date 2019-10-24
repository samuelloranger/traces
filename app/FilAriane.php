<?php
declare(strict_types=1);

namespace App;

use App\Modeles\Livre;

class FilAriane
{

    private $session = null;

    public function __construct()
    {
        $this->session = App::getInstance()->getSession();
    }

    public static function majFilAriane(): array{
        $fil = array();

        //Si le contrôleur est défini
        if(isset($_GET["controleur"])){
            //Si le contrôleur n'est pas celui du site, nous sommes au deuxième niveau
            if($_GET["controleur"] !== 'site') {
                $action = $_GET["action"];
                switch(true){
                    //Si l'action est d'afficher une liste de livres
                    case $action === 'catalogue' :

                        //Lien de retour vers l'accueil
                        $lien0 = array(
                            "titre" => "Accueil",
                            "lien" => "index.php?controleur=site&action=accueil"
                        );

                        //Titre de la page
                        if(isset($_GET["nouveau"])){
                            $lien1 = array("titre"=>"Nouveautés");
                        }else{
                            $lien1 = array("titre"=>"Catalogue");
                        }

                        $fil[0] = $lien0;
                        $fil[1] = $lien1;
                    break;

                    //Si l'action d'afficher une fiche de livre
                    case $action === 'fiche' :

                        //Lien de retour vers l'accueil
                        $lien0 = array(
                            "titre"=>"Accueil",
                            "lien"=>"index.php?controleur=site&action=accueil"
                        );

                        //Definition du premier lien
                        $fil[0] = $lien0;

                        //Lien vers la liste des pages se qualifiant (catégorie, nouveauté...)
                        if(isset($_GET["nouveaute"])){
                            $lien2 = array(
                                "titre" => "Nouveautés",
                                "lien" => "index.php?controleur=site&action=accueil#nouveautes"
                            );
                        }
                        else if(isset($_GET["coupCoeur"])){
                            $lien1 = array(
                                "titre" => "Coups de coeur",
                                "lien" => "index.php?controleur=site&action=accueil#coupdecoeurs"
                            );
                        }
                        else{
                            $lien1 = array(
                                "titre" => "Catalogue",
                                "lien" => "index.php?controleur=livre&action=catalogue"
                            );
                        }

                        //Definition du 2e lien
                        $fil[1] = $lien1;

                        //Definition du titre du livre
                        if(isset($_GET["isbn"])) {
                            $livre = Livre::trouverParIsbn($_GET["isbn"]);

                            //Definition du 3e lien (si necessaire)
                            if($lien1["titre"] == "Catalogue"){
                                $infosCategories = $livre->getInfosCategorieLivre();
                                $lien3 = array(
                                    "titre" => $infosCategories["nom_fr"],
                                    "lien" => "index.php?controleur=livre&action=catalogue&categorie=" . $infosCategories["id"]
                                );

                                $fil[2] = $lien3;
                            }

                            $fil[3] = array(
                                "titre" => $livre->__get("titre")
                            );
                        }
                        break;
                }
            }
        }
        return $fil;
    }

    // Getter magique
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    // Setter magique
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}