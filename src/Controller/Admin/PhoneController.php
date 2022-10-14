<?php

namespace App\Controller\Admin;

use App\Entity\Phone;
use App\Form\PhoneType;
use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    /**
     * @Route("/admin/phone/", name="admin_phone_index", methods={"GET"})
     */
    public function index(PhoneRepository $phoneRepository): Response
    {
        return $this->render('admin/phone/index.html.twig', [
            'phones' => $phoneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/phone/new", name="admin_phone_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $phone = new Phone();
        $phone->setUser($this->getUser());
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
        
            $entityManager->persist($phone);
            $entityManager->flush();

            return $this->redirectToRoute('admin_phone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/phone/new.html.twig', [
            'phone' => $phone,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/main/phone/new", name="main_phone_new", methods={"GET","POST"})
     */
    public function newPhone(Request $request, PhoneRepository $phoneRepository): Response
    {
        $reponse = [
            'reponse'=>false,
            'error'=>1
        ];
        $phone = new Phone();
        $phone->setUser($this->getUser());

        $submittedToken = $request->request->get('_token');
        $isWhatsapp = $request->request->get('isWhatsapp') == 'Oui' ? true: false;
        $valeur = $request->request->get('valeur');
        $valeur = str_replace(' ','',$valeur);
        $phone->setIsWhatsapp($isWhatsapp);
        $phone->setValeur($valeur);
         
        if ($this->isCsrfTokenValid('add-phone-item', $submittedToken)) {
            
            //ON VERIFIE L'EXISTENCE DU NUMERO
            $phoneExist = $phoneRepository->findOneBy([
                'valeur'=>$phone->getValeur(),
                'user'=>$phone->getUser()->getId()
            ]);
            if(!$phoneExist){
                $entityManager = $this->getDoctrine()->getManager();
                
                    $entityManager->persist($phone);
                    $entityManager->flush();
                $reponse = [
                    'reponse'=>true
                ];
            }else{
                $reponse = [
                    'reponse'=>false,
                    'error'=>2
                ];
            }
            return new JsonResponse($reponse);
        }
        
        return new JsonResponse($reponse);
    }

    /**
     * @Route("/admin/phone/{id}", name="admin_phone_show", methods={"GET"})
     */
    public function show(Phone $phone): Response
    {
        return $this->render('admin/phone/show.html.twig', [
            'phone' => $phone,
        ]);
    }

    /**
     * @Route("/admin/phone/{id}/edit", name="admin_phone_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Phone $phone): Response
    {
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_phone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/phone/edit.html.twig', [
            'phone' => $phone,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/main/phone/{id}/load", name="main_phone_edit_load", methods={"GET","POST"})
     */
    public function editPhoneLoad(Phone $phone): Response
    {
        return new JsonResponse([
            'content'=>$this->render('admin/profile/_phone_edit.html.twig',['phone'=>$phone])->getContent()
        ]);
    }
    /**
     * @Route("/main/phone/{id}/edit", name="main_phone_edit", methods={"GET","POST"})
     */
    public function editPhone(Request $request, Phone $phone, PhoneRepository $phoneRepository): Response
    {
        $reponse = [
            'reponse'=>false,
            'error'=>1
        ];
        $submittedToken = $request->request->get('_token');
        $isWhatsapp = $request->request->get('isWhatsapp') == 'Oui' ? true: false;
        $valeur = $request->request->get('valeur');
        $valeur = str_replace(' ','',$valeur);
        $phone->setIsWhatsapp($isWhatsapp);
        $phone->setValeur($valeur);
         
        if ($this->isCsrfTokenValid('update-phone-item', $submittedToken)) {
            
            //ON VERIFIE L'EXISTENCE DU NUMERO
            $phoneExist = $phoneRepository->findOneBy([
                'valeur'=>$phone->getValeur(),
                'user'=>$phone->getUser()->getId()
            ]);
            if(!$phoneExist){
                $entityManager = $this->getDoctrine()->getManager();                
                    $entityManager->flush();
                $reponse = [
                    'reponse'=>true
                ];
            }else{
                $reponse = [
                    'reponse'=>false,
                    'error'=>2
                ];
            }
            return new JsonResponse($reponse);
        }
        
        return new JsonResponse($reponse);
        $form = $this->createForm(PhoneType::class, $phone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_phone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/phone/edit.html.twig', [
            'phone' => $phone,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/phone/{id}", name="admin_phone_delete", methods={"POST"})
     */
    public function delete(Request $request, Phone $phone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phone->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_phone_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/main/phone/{id}", name="main_phone_delete", methods={"POST"})
     */
    public function deletePhone(Request $request, Phone $phone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phone->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phone);
            $entityManager->flush();
            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }
    /**
     * @Route("/main/load-phone-list", name="main_load_phone_list", methods={"GET","POST"})
     */
    public function loadPhoneList(): Response
    {
        return  new JsonResponse(['content'=>$this->render('admin/profile/_phone_list.html.twig')->getContent()]);   
    }
}
