<?php

namespace App\Service\Email;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    private $translator;
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translator =$translatorInterface;
    }
    public function theme($id)
    {
        $id_user = 1;
        $cle_user = 'cleuser1';
        $cle= '';
        $site = 'Les professionelle de la technologie.';
        $introduction = 'Site de vente en ligne.';
        $link_site = 'https://lest.sn';
        $link_img = $link_site.'/public/assets/images/lest-jaune.png';
        $message = '';
        $link_contrat = $link_site."/public/doc/condition-d'utilisation-lest.pdf";
        $button_link = $link_site;
        $button_text = '';
        $titre = '';
        $link_disinscription = $link_site.'/se-desinscrire-'.$id_user.'-tkr'.$cle_user.'-lest';
        switch ($id) {
          case '1':
            // inscription verification ou desinscription
              $introduction = '';
              $button_link = '/gestion-compte/delete-account/{token}/{id}';
              $button_text = 'Nos catégories';
              $titre ="Email de confirmation";
              $message = 'Votre compte client lest a été bien enregistré.';
            break;
          case '2':
            // mot de passeoublier
            $introduction = '';
            $button_link = null;
            $button_text = 'Modifier votre mot de passe';
              $titre = 'Veuillez modifier votre mot de passe';
              $message = 'Étiez-vous à l’origine de la modfication de votre compte lest ? Si oui, voici le lien de modification.';
            break;
          case '3':
            // modifier l'email
            $introduction = '';
            $button_link = null;
            $button_text = 'Modifier mon email';
              $titre = 'Veuillez modifier email';
              $message = 'Étiez-vous à l’origine de la modfication de votre compte lest ? Si oui, voici le lien de modification.';
            break;
          case '4':
            // nouvell commande
            $introduction = '';
            $button_link = null;
            $button_text = null;
              $titre = 'Avis de facture';
              $message = 'Une facture a été générée';
            break;
          case '5':
            // confirmaion user
            $introduction = '';
            $button_link ='app_login' ;
            $button_text = 'Se connecter';
              $titre = "Avis de création d'un compte utilisateur";
              $message = 'Un nouveau compte a été crée.';
            break;
          case '5.1':
            // confirmaion user none
            $introduction = '';
            $button_link ='app_login' ;
            $button_text = 'Se connecter';
              $titre = "Avis de création d'un compte utilisateur";
              $message = 'Un nouveau compte a été crée.';
            break;
          case '6':
            // contact
            $introduction = '';
            $button_link =null ;
            $button_text = null;
              $titre = "Message visiteur";
              $message = 'Un nouveau message a été crée.';
            break;
          case '7':
            // facture
            $introduction = '';
            $button_link =null ;
            $button_text = null;
              $titre = "Avis de facture";
              $message = 'Reçu de paiement.';
            break;
          case '8':
            // facture
            $introduction = '';
            $button_link =null ;
            $button_text = null;
              $titre = "Nouvelle commande";
              $message = 'Une commande est en attente.';
            break;

          default:
            // code...
            break;
        }
        return 
        [
            'name'=>$titre,
            'message'=>$message,
            'btn'=>[
                'path'=>$button_link,
                'text'=>$button_text
            ],
            'resetToken'=>'reset/NLsV4E2rKC57yaBv2Ib2VAp2n3HKzFXjFCRRULa9'
        ];
    }
}
