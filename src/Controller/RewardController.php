<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RewardController extends AbstractController
{
    /**
     * @Route("/rewards", name="app_reward")
     */
    public function index(): Response
    {
        return $this->render('reward/index.html.twig', [

        ]);
    }
}
