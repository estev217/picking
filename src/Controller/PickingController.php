<?php

namespace App\Controller;

use App\Entity\SavRetour\Picking;
use App\Form\SavRetour\PickingType;
use App\Repository\SavRetour\PickingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/picking")
 */
class PickingController extends AbstractController
{
    /**
     * @Route("/", name="picking_index", methods={"GET"})
     */
    public function index(PickingRepository $pickingRepository): Response
    {
        return $this->render('picking/index.html.twig', [
            'pickings' => $pickingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="picking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $picking = new \App\Entity\SavRetour\Picking();
        $form = $this->createForm(PickingType::class, $picking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($picking);
            $entityManager->flush();

            return $this->redirectToRoute('picking_index');
        }

        return $this->render('picking/new.html.twig', [
            'picking' => $picking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="picking_show", methods={"GET"})
     */
    public function show(Picking $picking): Response
    {
        return $this->render('picking/show.html.twig', [
            'picking' => $picking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="picking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Picking $picking): Response
    {
        $form = $this->createForm(PickingType::class, $picking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('picking_index');
        }

        return $this->render('picking/edit.html.twig', [
            'picking' => $picking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="picking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Picking $picking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('picking_index');
    }
}
