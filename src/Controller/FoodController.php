<?php

namespace App\Controller;

use App\Form\FoodType;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    /**
     * @var FoodRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(FoodRepository $repository,EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/menu/food", name="app_food_index")
     */
    public function index(): Response
    {
        $food = $this->repository->findAllFood();

        return $this->render('food/index.html.twig', [
            'food' => $food,
        ]);
    }

    /**
     * @Route("/menu/food/new",name="app_food_new")
     */
    public function newFood(Request $request) {
        $form = $this->createForm(FoodType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $food = $form->getData();

            $this->manager->persist($food);
            $this->manager->flush();

            return $this->redirectToRoute('app_food_index');
        }

        return $this->render('food/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/menu/food/{id}/delete",name="app_food_delete")
     */
    public function deleteFood(int $id) {
        $food = $this->repository->findOneBy(['id' => $id]);

        if(!$food) {
            throw  $this->createNotFoundException('Not food found for id '.$food->getId());
        }

        $this->manager->remove($food);
        $this->manager->flush();

        return $this->redirectToRoute('app_food_index');
    }

    /**
     * @Route("/menu/food/{id}/edit",name="app_food_edit")
     */
    public function editFood(int $id,Request $request) {
        $food = $this->repository->findOneBy(['id' => $id]);

        $form = $this->createForm(FoodType::class,$food);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($food);
            $this->manager->flush();

            $this->addFlash('success','Yessss All Done !! Your Food Product Updated ...');

            return $this->redirectToRoute('app_food_index',[
                'id' => $food->getId()
            ]);
        }
        return $this->render('food/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
