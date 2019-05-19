<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Passager;
use App\Form\Passager1Type;
use App\Entity\Chauffeur;
use App\Form\Chauffeur1Type;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $passager = new Passager();
        $chauffeur = new Chauffeur();
        $passagerForm = $this->createForm(Passager1Type::class, $passager);
        $chauffeurForm = $this->createForm(Chauffeur1Type::class, $chauffeur);
        $passagerForm->handleRequest($request);
        $chauffeurForm->handleRequest($request);

        if ($chauffeurForm->isSubmitted() && $chauffeurForm->isValid()) {
            $chauffeur->setPassword($encoder->encodePassword($chauffeur, $chauffeur->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chauffeur);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        if ($passagerForm->isSubmitted() && $passagerForm->isValid()) {
            $passager->setPassword($encoder->encodePassword($passager, $passager->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($passager);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('register/index.html.twig', [
            'passager' => $passager,
            'chauffeur' => $chauffeur,
            'passagerForm' => $passagerForm->createView(),
            'chauffeurForm' => $chauffeurForm->createView(),
            'controller_name' => 'RegisterController',
        ]);
    }
}
