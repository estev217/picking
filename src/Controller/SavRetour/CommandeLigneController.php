<?php

namespace App\Controller\SavRetour;

use App\Entity\SavRetour\CommandeLigne;
use App\Form\SavRetour\CommandeLigneType;
use App\Repository\SavRetour\CommandeLigneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sav/retour/commande/ligne")
 */
class CommandeLigneController extends AbstractController
{
    /**
     * @Route("/", name="sav_retour_commande_ligne_index", methods={"GET"})
     */
    public function index(CommandeLigneRepository $commandeLigneRepository): Response
    {
        return $this->render('sav_retour/commande_ligne/index.html.twig', [
            'commande_lignes' => $commandeLigneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sav_retour_commande_ligne_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commandeLigne = new CommandeLigne();
        $form = $this->createForm(CommandeLigneType::class, $commandeLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commandeLigne);
            $entityManager->flush();

            return $this->redirectToRoute('sav_retour_commande_ligne_index');
        }

        return $this->render('sav_retour/commande_ligne/new.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sav_retour_commande_ligne_show", methods={"GET"})
     */
    public function show(CommandeLigne $commandeLigne): Response
    {
        return $this->render('sav_retour/commande_ligne/show.html.twig', [
            'commande_ligne' => $commandeLigne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sav_retour_commande_ligne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeLigne $commandeLigne): Response
    {
        $form = $this->createForm(CommandeLigneType::class, $commandeLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sav_retour_commande_ligne_index');
        }

        return $this->render('sav_retour/commande_ligne/edit.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sav_retour_commande_ligne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeLigne $commandeLigne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeLigne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeLigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sav_retour_commande_ligne_index');
    }
}
