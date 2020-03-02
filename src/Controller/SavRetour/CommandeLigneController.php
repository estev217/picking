<?php

namespace App\Controller\SavRetour;

use App\Entity\SavRetour\CommandeLigne;
use App\Entity\SavRetour\CommandeLigneSearch;
use App\Form\SavRetour\CommandeLigneType;
use App\Form\SavRetour\CommandeLigneSearchType;
use App\Repository\SavRetour\CommandeLigneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande_ligne")
 */
class CommandeLigneController extends AbstractController
{
    /**
     * @Route("/", name="commande_ligne_index", methods={"GET"})
     */
    public function index(CommandeLigneRepository $commandeLigneRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new CommandeLigneSearch();

        $form = $this->createForm(CommandeLigneSearchType::class, $search);
        $form->handleRequest($request);

        $commandeLignes = $paginator->paginate(
            $commandeLigneRepository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('commande_ligne/index.html.twig', [
            'commande_lignes' => $commandeLignes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="commande_ligne_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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

            return $this->redirectToRoute('commande_ligne_index');
        }

        return $this->render('commande_ligne/new.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_ligne_show", methods={"GET"})
     */
    public function show(CommandeLigne $commandeLigne): Response
    {
        return $this->render('commande_ligne/show.html.twig', [
            'commande_ligne' => $commandeLigne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_ligne_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CommandeLigne $commandeLigne
     * @return Response
     */
    public function edit(Request $request, CommandeLigne $commandeLigne): Response
    {
        $form = $this->createForm(CommandeLigneType::class, $commandeLigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_ligne_index');
        }

        return $this->render('commande_ligne/edit.html.twig', [
            'commande_ligne' => $commandeLigne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_ligne_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CommandeLigne $commandeLigne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeLigne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commandeLigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_ligne_index');
    }
}
