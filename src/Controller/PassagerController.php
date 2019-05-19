<?php

namespace App\Controller;

use App\Entity\Passager;
use App\Form\Passager1Type;
use App\Repository\PassagerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/passager")
 */
class PassagerController extends AbstractController
{
    /**
     * @Route("/", name="passager_index", methods={"GET"})
     */
    public function index(PassagerRepository $passagerRepository): Response
    {
        return $this->render('passager/index.html.twig', [
            'passagers' => $passagerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="passager_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $passager = new Passager();
        $form = $this->createForm(Passager1Type::class, $passager);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $passager->setPassword($encoder->encodePassword($passager,$passager->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($passager);
            $entityManager->flush();

            return $this->redirectToRoute('passager_index');
        }

        return $this->render('passager/new.html.twig', [
            'passager' => $passager,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="passager_show", methods={"GET"})
     */
    public function show(Passager $passager): Response
    {
        return $this->render('passager/show.html.twig', [
            'passager' => $passager,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="passager_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Passager $passager): Response
    {
        $form = $this->createForm(Passager1Type::class, $passager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('passager_index', [
                'id' => $passager->getId(),
            ]);
        }

        return $this->render('passager/edit.html.twig', [
            'passager' => $passager,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="passager_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Passager $passager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$passager->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($passager);
            $entityManager->flush();
        }

        return $this->redirectToRoute('passager_index');
    }
}
