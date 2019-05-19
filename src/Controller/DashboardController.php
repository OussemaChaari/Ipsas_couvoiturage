<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trajet;
use App\Entity\Reservation;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(UserInterface $user)
    {
        $trajetRepo = $this->getDoctrine()->getRepository(Trajet::class);
        $trajets = $trajetRepo->findAll();
        $reservationRepo = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $reservationRepo->findBy(['idPass' => $user]);
        $reservedTrajs = [];
        foreach ($reservations as $reservation) {
            $reservedTrajs[] = $reservation->getIdTraj()->getId();
        }
        return $this->render('dashboard/index.html.twig', [
            'trajets' => $trajets,
            'reservations' => $reservedTrajs
        ]);
    }

    /**
     * @Route("/reserve/{trajetId}", name="reserve")
     */
    public function reserver($trajetId, UserInterface $user)
    {
        $trajetRepo = $this->getDoctrine()->getRepository(Trajet::class);
        $trajet = new Trajet();
        $trajet = $trajetRepo->find($trajetId);
        $trajet->setPlaceLibres($trajet->getPlaceLibres() - 1);

        $reservation = new Reservation();
        $reservation->setDateRes(new \DateTime());
        $reservation->setIdPass($user);
        $reservation->setIdTraj($trajet);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('dashboard');
    }
}
