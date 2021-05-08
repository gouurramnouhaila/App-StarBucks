<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
    public function register(Request $request,UserPasswordEncoderInterface $encoder,GuardAuthenticatorHandler $handler,FormLoginAuthenticator $authenticator) {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var $user User */
            $user = $form->getData();

            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));

            $this->manager->persist($user);
            $this->manager->flush();

            return $handler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );

        }

        return $this->render('security/user/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
