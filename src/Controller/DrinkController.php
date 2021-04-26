<?php

namespace App\Controller;

use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrinkController extends AbstractController
{
    /**
     * @var DrinkRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(DrinkRepository $repository,EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/menu/drink", name="app_drink_index")
     */
    public function index(): Response
    {
        $drinks = $this->repository->findAllDrink();

        return $this->render('drink/index.html.twig', [
            'drinks' => $drinks,
        ]);
    }

    /**
     * @Route("/menu/drink/new",name="app_drink_new")
     */
    public function newDrink(Request $request) {
        $form = $this->createForm(DrinkType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $drink = $form->getData();

            $this->manager->persist($drink);
            $this->manager->flush();

            return $this->redirectToRoute('app_drink_index');
        }

        return $this->render('drink/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/menu/drink/{id}/delete",name="app_drink_delete")
     */
    public function deleteDrink(int $id) {
        $drink = $this->repository->findOneBy(['id' => $id]);

        if(!$drink) {
            throw $this->createNotFoundException('Not drink found for id '.$drink->getId());
        }

        $this->manager->remove($drink);
        $this->manager->flush();

        return $this->redirectToRoute('app_drink_index');
    }

    /**
     * @Route("/menu/drink/{id}/edit",name="app_drink_edit")
     */
    public function editDrink(int $id,Request $request) {
        $drink = $this->repository->findOneBy(['id' => $id]);

        $form = $this->createForm(DrinkType::class,$drink);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($drink);
            $this->manager->flush();

            $this->addFlash('success','Yessss All Done !! Your Drink Product Updated ... ');

            return $this->redirectToRoute('app_drink_index',[
                'id' => $drink->getId()
            ]);
        }
        return $this->render('drink/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
