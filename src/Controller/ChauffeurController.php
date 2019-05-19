<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Form\Chauffeur1Type;
use App\Repository\ChauffeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/chauffeur")
 */
class ChauffeurController extends AbstractController
{
    /**
     * @Route("/", name="chauffeur_index", methods={"GET"})
     */
    public function index(ChauffeurRepository $chauffeurRepository): Response
    {
        return $this->render('chauffeur/index.html.twig', [
            'chauffeurs' => $chauffeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="chauffeur_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $chauffeur = new Chauffeur();
        $form = $this->createForm(Chauffeur1Type::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chauffeur->setPassword($encoder->encodePassword($chauffeur,$chauffeur->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chauffeur);
            $entityManager->flush();

            return $this->redirectToRoute('chauffeur_index');
        }

        return $this->render('chauffeur/new.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chauffeur_show", methods={"GET"})
     */
    public function show(Chauffeur $chauffeur): Response
    {
        return $this->render('chauffeur/show.html.twig', [
            'chauffeur' => $chauffeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chauffeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chauffeur $chauffeur): Response
    {
        $form = $this->createForm(Chauffeur1Type::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chauffeur_index', [
                'id' => $chauffeur->getId(),
            ]);
        }

        return $this->render('chauffeur/edit.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chauffeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Chauffeur $chauffeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chauffeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chauffeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chauffeur_index');
    }
}
