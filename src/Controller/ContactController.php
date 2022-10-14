<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Form\ContactType;
use App\Service\Email\EmailService;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailerInterface, TranslatorInterface $translator, EmailService $emailService): Response
    {
        $formContact = $this->createForm(ContactType::class);
        $contact = $formContact->handleRequest($request);

        $reCAPTCHA_secret_key="6LfDomMhAAAAAG1cNp7cAYHiI6NBvfdsM-ItcCru";
        $g_recaptcha_response="";
        $ip = $_SERVER['REMOTE_ADDR'];
        $globals = $this->get('twig')->getGlobals();

        if($formContact->isSubmitted() && $formContact->isValid()){
            $g_recaptcha_response = $request->request->get('g-recaptcha-response');
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
        . urlencode($reCAPTCHA_secret_key) . '&response=' 
        . urlencode($g_recaptcha_response) . '&remoteip=' 
        . urlencode($ip);
        $response = file_get_contents($url);
        $responeKey = json_decode($response,true);
        if($responeKey['success']){        
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($globals['site']['email'])
                ->subject('Contact depuis le site malick tounkara')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'theme'=>$emailService->theme(6),
                    'name'=>$contact->get('name')->getData(),
                    'mail'=>$contact->get('email')->getData(),
                    'phone'=>$contact->get('phone_number')->getData(),
                    'object'=>$contact->get('object')->getData(),
                    'message'=>$contact->get('message')->getData(),
                ])
                ;
            $mailerInterface->send($email);
            $message = $translator->trans('Email send');
            $this->addFlash('success',$message);
            return $this->redirectToRoute('contact');
            }elseif($responeKey['error-codes']){
                $this->addFlash('errors','Captcha invalide');
              }else{
                $this->addFlash('errors','Une erreur est survenu');
              }
        }
        return $this->renderForm($this->getParameter('template').'/contact/index.html.twig', [
            'form_contact' =>$formContact
        ]);
    }
}
