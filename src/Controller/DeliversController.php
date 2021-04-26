<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliversController extends AbstractController
{
    /**
     * @Route("/delivers", name="app_delivers")
     */
    public function index(): Response
    {
        return $this->render('delivers/index.html.twig', [

        ]);
    }
}
