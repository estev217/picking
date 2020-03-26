<?php

namespace App\Controller;

use App\Entity\Operateur;
use App\Form\OperateurType;
use App\Repository\OperateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operateur")
 */
class OperateurController extends AbstractController
{
    /**
     * @Route("/", name="operateur_index", methods={"GET"})
     */
    public function index(OperateurRepository $operateurRepository): Response
    {
        return $this->render('operateur/index.html.twig', [
            'operateurs' => $operateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="operateur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operateur = new Operateur();
        $form = $this->createForm(OperateurType::class, $operateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operateur);
            $entityManager->flush();

            return $this->redirectToRoute('operateur_index');
        }

        return $this->render('operateur/new.html.twig', [
            'operateur' => $operateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operateur_show", methods={"GET"})
     */
    public function show(Operateur $operateur): Response
    {
        return $this->render('operateur/show.html.twig', [
            'operateur' => $operateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Operateur $operateur): Response
    {
        $form = $this->createForm(OperateurType::class, $operateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operateur_index');
        }

        return $this->render('operateur/edit.html.twig', [
            'operateur' => $operateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Operateur $operateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operateur_index');
    }
}
