<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class CouvoiturageController extends Controller
{
    /** 
     *  @Route("/")
     *  @Method({"GET"})
     **/
    public function index(UserInterface $user = null)
    {
        if ($user != null)
            return $this->render('pages/index.html.twig', [
                'user' => $user
            ]);
        else
            return $this->render('security/login.html.twig',[
                'error' => '',
                'last_username'=> ''
            ]);
    }
}
