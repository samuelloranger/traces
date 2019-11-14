<?php

declare(strict_types=1);

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Courriel
{

    private $courriel = null;


    public function __construct(string $unCourriel, array $infosClient){

        // Préparer le courriel

        // Préparer le contenu HTML du courriel
        $unTemps = time();
        $blade = App::getInstance()->getBlade();
        $tDonnees = $infosClient;
        $unContenuHTML = $blade->run("courriels.courrielConfirmation", $tDonnees);
        $unContenuHTML_enTexte = 'Le contenu sans HTML... Bonjour!';


        $this->courriel = new PHPMailer(true); // True indique que les exceptions seront lancées (Throwable) et non retourné en valeur retour de la méthode send


        //Configuration du serveur d'envoi
        $this->courriel->SMTPDebug  = 0;                                      // Activer le débogage 0 = off, 1 = messages client, 2 = messages client et serveur
        $this->courriel->isSMTP();                                            // Envoyer le courriel avec le protocole standard SMTP
        $this->courriel->Host       = 'smtp.gmail.com';                    // Adresse du serveur d'envoi SMTP
        $this->courriel->SMTPAuth   = true;                                   // Activer l'authentification SMTP
        $this->courriel->Username   = 'papineauo.pwem4@gmail.com';           // Nom d'utilisateur SMTP
        $this->courriel->Password   = 'Zerkopok4242';                         // Mot de passe SMTP
        $this->courriel->SMTPSecure = 'TLS';                                  // Activer l'encryption TLS, `PHPMailer::ENCRYPTION_SMTPS` est aussi accepté
        $this->courriel->Port       = 587;                                    // Port TCP à utiliser pour la connexion SMTP

        // Configuration du courriel

        // De:
        $this->courriel->setFrom('papineauo.pwem4@gmail.com'); // Définir l'adresse de l'envoyeur.

        // À:
        $this->courriel->addAddress($unCourriel);      // Ajouter l'adresse du destinataire (le nom est optionel)
        //$this->courriel->addReplyTo('info@example.com', 'Information');
        //$this->courriel->addCC('cc@example.com');            // Ajouter un destinataire en copie conforme
        //$this->courriel->addBCC('bcc@example.com');          // Ajouter un destinataire caché en copie conforme

        // Fichiers joints:
        //$this->courriel->addAttachment('/var/tmp/file.tar.gz');       // Ajouter un fichier joint
        //$this->courriel->addAttachment('/tmp/image.jpg', 'new.jpg');  // Ajouter un fichier joint avec un nom (Optionel)

        // Contenu:
        $this->courriel->isHTML(true);  // Définir le type de contenu du courriel.
        $this->courriel->Subject = 'Merci pour votre commande';
        $this->courriel->Body    = $unContenuHTML;
        $this->courriel->AltBody = $unContenuHTML_enTexte; // Si le client ne supporte pas le courriels HTML
    }

    public function envoyer():string
    {
        try {
            $this->courriel->send();
            return "Le message a été envoyé.";
        } catch (Exception $e) {
            // Gérer les exceptions spécifique à PHPMailer
            return  "Le message ne peut pas être envoyé.";

        } catch (\Exeception $e) {
            // Gérer les exeptions internes de PHP
            return "Le message ne peut pas être envoyé.";
        }
    }

}

