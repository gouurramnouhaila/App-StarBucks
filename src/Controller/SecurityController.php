<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Handler\UserHandler;
use App\Security\FormLoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class SecurityController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/login",name="app_login")
     */
    public function login() {

        return $this->render('security/login.html.twig',[]);
    }

    /**
     * @Route("/security", name="security")
     */
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/account/create",name="app_account_create")
     */
    public function register(Request $request,GuardAuthenticatorHandler $handler,FormLoginAuthenticator $authenticator,UserHandler $userHandler) {

        $user = new User();

        if($userHandler->handle($request,$user)) {

           return $handler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );

        }

        return $this->render('security/user/register.html.twig',[
            'form' => $userHandler->createView()
        ]);
    }
}
