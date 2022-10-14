<?php

namespace App\Controller\Admin;

use App\Entity\Coupon;
use App\Form\CouponType;
use App\Repository\CouponRepository;
use App\Service\Service;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/admin/coupon")
 */
class CouponController extends AbstractController
{
    /**
     * @Route("/", name="admin_coupon_index", methods={"GET"})
     */
    public function index(CouponRepository $couponRepository): Response
    {
        return $this->render('admin/coupon/index.html.twig', [
            'coupons' => $couponRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_coupon_new", methods={"GET","POST"})
     */
    public function new(Request $request, Service $service): Response
    {
        $coupon = new Coupon();
        $coupon->setDebut(new DateTime());
        $coupon->setFin(new DateTime('+ 1 month'));
        $coupon->setCode($service->coupon());
        // dd($coupon);
        $form = $this->createForm(CouponType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coupon);
            $entityManager->flush();

            return $this->redirectToRoute('admin_coupon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coupon/new.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_coupon_show", methods={"GET"})
     */
    public function show(Coupon $coupon): Response
    {
        return $this->render('admin/coupon/show.html.twig', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_coupon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coupon $coupon): Response
    {
        $form = $this->createForm(CouponType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_coupon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/coupon/edit.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_coupon_delete", methods={"POST"})
     */
    public function delete(Request $request, Coupon $coupon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coupon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coupon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_coupon_index', [], Response::HTTP_SEE_OTHER);
    }
}
