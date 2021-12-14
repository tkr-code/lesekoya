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

        if($formContact->isSubmitted() && $formContact->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('malick.tounkara.1@gmail.com')
                ->subject('Contact depuis le site malick tounkara')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'theme'=>$emailService->theme(6),
                    'name'=>$contact->get('name')->getData(),
                    'mail'=>$contact->get('email')->getData(),
                    'phone'=>$contact->get('phone_number')->getData(),
                    'message'=>$contact->get('message')->getData(),
                ])
                ;
            $mailerInterface->send($email);
            $message = $translator->trans('Email send');
            $this->addFlash('success',$message);
            return $this->redirectToRoute('contact');
        }
        return $this->renderForm('lesekoya/contact/index.html.twig', [
            'form_contact' =>$formContact
        ]);
    }
}
