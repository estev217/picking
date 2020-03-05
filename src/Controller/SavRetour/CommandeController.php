<?php

namespace App\Controller\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Form\SavRetour\CommandeType;
use App\Repository\SavRetour\CommandeLigneRepository;
use App\Repository\SavRetour\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param CommandeLigneRepository $commandeLigneRepository
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, CommandeLigneRepository $commandeLigneRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAllWithNumCmd(),
            'commandelignes' => $commandeLigneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="commande_list", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @return Response
     */
    public function list(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/list.html.twig', [
            'commandes' => $commandeRepository->findAllByNum(),
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $numCommande = $form['numCommande']->getData();
            $entityManager->persist($commande);
            $entityManager->flush();

            return new RedirectResponse($this->generateUrl('commande_ligne_new', [
                'numCommande' => $numCommande]));
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     * @param Commande $commande
     * @return Response
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_index');
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"DELETE"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index');
    }
}
