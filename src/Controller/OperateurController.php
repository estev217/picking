<?php

namespace App\Controller;

use App\Entity\Operateur;
use App\Form\OperateurEditType;
use App\Form\OperateurType;
use App\Form\RegistrationFormType;
use App\Repository\OperateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Operateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            if ($user->getRole()->getIdentifier() === "admin") {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $user->setRoles(["ROLE_OPERATEUR"]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('operateur_index');
        }

        return $this->render('operateur/new.html.twig', [
            'operateur' => $user,
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
    public function edit(Request $request, Operateur $operateur, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(OperateurType::class, $operateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($operateur->getRole()->getIdentifier() === "admin") {
                $operateur->setRoles(["ROLE_ADMIN"]);
            } else {
                $operateur->setRoles(["ROLE_OPERATEUR"]);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'primary',
                'Profil mis à jour !'
            );

            return $this->redirectToRoute('operateur_index');
        }

        return $this->render('operateur/edit.html.twig', [
            'operateur' => $operateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/password", name="operateur_edit_password", methods={"GET","POST"})
     * @param Request $request
     * @param Operateur $operateur
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function editPassword(Request $request, Operateur $operateur, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(OperateurEditType::class, $operateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $operateur->setPassword(
                $passwordEncoder->encodePassword(
                    $operateur,
                    $form->get('password')->getData()
                )
            );

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'primary',
                'Mot de passe mis à jour !'
            );

            return new RedirectResponse($this->generateUrl('operateur_edit', [
                'id' => $operateur->getId(),
            ]));
        }

        return $this->render('operateur/password.html.twig', [
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
