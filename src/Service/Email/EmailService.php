<?php

namespace App\Service\Email;

use Symfony\Contracts\Translation\TranslatorInterface;

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
        $site = 'Gaboma annonce';
        $introduction = 'Site de petites annonces.';
        $link_site = 'https://gaboma-annonce.com';
        $link_img = $link_site.'/public/img/icons/gaboma-icon.png';
        $message = '';
        $link_contrat = $link_site."/public/doc/condition-d'utilisation-gaboma-annonce.pdf";
        $button_link = $link_site;
        $button_text = '';
        $titre = '';
        $link_disinscription = $link_site.'/se-desinscrire-'.$id_user.'-tkr'.$cle_user.'-gaboma-annonce';
        switch ($id) {
          case '1':
            // inscription verification ou desinscription
              $introduction = '';
              $button_link = $link_site.'/publications';
              $button_text = 'Nos catégories';
              $titre =$this->translator->trans('Hi! Please confirm your email!');
              $message = 'Votre compte leSekoya est en attente de confirmation.';
            break;
          case '2':
            // mot de passeoublier
            $introduction = '';
            $button_link = $link_site.'/modifier-le-mot-de-passe-'.$id_user.'-tkr'.$cle.'-gaboma-annonce';
            $button_text = 'Modifier votre mot de passe';
              $titre = 'Veuillez modifier votre mot de passe';
              $message = 'Étiez-vous à l’origine de la modfication de votre compte leSekoya ? Si oui, voici le lien de modification.';
            break;
          case '3':
            // modifier l'email
            $introduction = '';
            $button_link = $link_site.'/modifier-email-'.$id_user.'-tkr'.$cle.'-gaboma-annonce';
            $button_text = 'Modifier votre e-mail';
              $titre = 'Veuillez modifier e-mail';
              $message = 'Étiez-vous à l’origine de la modfication de votre compte gaboma annonce ? Si oui, voici le lien de modification.';
            break;

          default:
            // code...
            break;
        }
        return 
        [
            'theme'=>[
                'name'=>$titre
            ],
            'message'=>$message,
            'btn'=>[
                'path'=>$button_link,
                'text'=>$button_text
            ],
            'resetToken'=>'reset/NLsV4E2rKC57yaBv2Ib2VAp2n3HKzFXjFCRRULa9'
        ];
    }
}
