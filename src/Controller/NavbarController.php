<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class NavbarController extends AbstractController
{
    /**
     * @Route("/navbar", name="navbar")
     */
    public function index(UserInterface $user = null)
    {
        return $this->render('navbar/index.html.twig', [
            'user' => $user
        ]);
    }
}
