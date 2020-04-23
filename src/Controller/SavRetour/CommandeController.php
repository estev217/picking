<?php

namespace App\Controller\SavRetour;

use App\Entity\SavRetour\Commande;
use App\Entity\SavRetour\CommandeLigne;
use App\Form\SavRetour\CommandeLigneNewType;
use App\Form\SavRetour\CommandeType;
use App\Repository\SavRetour\CommandeLigneRepository;
use App\Repository\SavRetour\CommandeRepository;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * @IsGranted("ROLE_ADMIN")
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
     * @Route("/all", name="commande_all", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param CommandeLigneRepository $commandeLigneRepository
     * @return Response
     */
    public function all(CommandeRepository $commandeRepository, CommandeLigneRepository $commandeLigneRepository): Response
    {
        return $this->render('commande/all.html.twig', [
            'commandes' => $commandeRepository->findAll(),
            'commandelignes' => $commandeLigneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/solde", name="commande_solde", methods={"GET"})
     * @param CommandeRepository $commandeRepository
     * @param CommandeLigneRepository $commandeLigneRepository
     * @return Response
     */
    public function solde(CommandeRepository $commandeRepository, CommandeLigneRepository $commandeLigneRepository): Response
    {
        return $this->render('commande/solde.html.twig', [
            'commandes' => $commandeRepository->findAll(),
            'commandelignes' => $commandeLigneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/upload", name="commande_upload", methods={"GET","POST"})
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Exception
     */
    public function upload(Request $request):Response
    {
        $file_mimes = ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);

            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();


            $commande = new Commande();
            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);

            $numCommande = $sheetData[5][2];
            $demandeur = $sheetData[4][2];
            $magasinCedant = $sheetData[9][2];
            $destination = $sheetData[8][2];
            $excelDate = $sheetData[3][2];

            if ($numCommande != null){
                $commande->setNumCommande($numCommande);
                if ($demandeur != null) {
                    $commande->setDemandeur($demandeur);
                } else {
                    $commande->setDemandeur("N.C.");
                }
                if ($magasinCedant != null) {
                    $commande->setMagasinCedant($magasinCedant);
                } else {
                    $commande->setMagasinCedant("N.C.");
                }
                if ($destination != null) {
                    $commande->setDestination($destination);
                } else {
                    $commande->setDestination("N.C.");
                }
                if ($excelDate != null) {
                    $formatedDate = date('Y-m-d H:i:s', strtotime($excelDate));
                    $dateTime = new \DateTime($formatedDate);
                    $commande->setDate($dateTime);
                } else {
                    $today = new \DateTime(date('Y-m-d H:i:s'));
                    $commande->setDate($today);
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($commande);

                $i = 12;
                while ($sheetData[$i][1] != null) {
                    $commandeLigne = new CommandeLigne();
                    $secondForm = $this->createForm(CommandeLigneNewType::class, $commandeLigne);
                    $secondForm->handleRequest($request);

                    $commandeLigne->setCommande($commande);
                    $gencod = $sheetData[$i][1];
                    $commandeLigne->setGencod($gencod);
                    $quantity = $sheetData[$i][4];
                    $commandeLigne->setQte($quantity);
                    $today = new \DateTime(date('Y-m-d H:i:s'));
                    $commandeLigne->setDate($today);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($commandeLigne);

                    $i++;
                }

                $entityManager->flush();

                $this->addFlash(
                    'primary',
                    'Commande créée !'
                );

                return $this->redirectToRoute('commande_index');

            } else {
                $this->addFlash(
                    'primary',
                    'Numéro de commande non valide ou introuvable !'
                );
            }

        }

        return $this->render('commande/upload.html.twig');
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

            $this->addFlash(
                'primary',
                'Commande créée !'
            );

            return new RedirectResponse($this->generateUrl('commande_ligne_new', [
                'numCommande' => $numCommande]));
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
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

            $this->addFlash(
                'primary',
                'Commande modifiée !'
            );

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

    /**
     * @Route("/delete/{id}", name="commande_delete_id", methods={"DELETE"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function deleteId(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_all');
    }

    /**
     * @Route("/delete/solde/{id}", name="commande_delete_solde", methods={"DELETE"})
     * @param Request $request
     * @param Commande $commande
     * @return Response
     */
    public function deleteSoldeId(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_solde');
    }
}
