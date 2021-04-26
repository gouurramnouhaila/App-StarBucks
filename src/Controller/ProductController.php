<?php

namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use App\Handler\ProductHandler;
use App\Repository\ProductRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

 /**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var FormFactoryInterface
     */
    private  $formFactory;

    public function __construct(ProductRepository $repository,EntityManagerInterface $manager,FormFactoryInterface $formFactory)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/products", name="app_product_index")
     */
    public function index()
    {
        $products = $this->repository->findAll();

        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/new",name="app_product_new")
     */
    public function newProduct(Request $request,ProductHandler $handler) {

        if($handler->handle($request,new Product(),ProductType::class)) {

            $this->addFlash('success', 'Yessss All Done !! Your Product Is Created ... ');

            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/new.html.twig',[
            'form' => $handler->createView()
        ]);
    }


    /**
     * @Route("/products/{id}/delete",name="app_product_delete")
     */
    public function deleteProduct(int $id) {
        $product = $this->repository->findOneBy(['id' => $id]);

        if(!$product) {
            throw $this->createNotFoundException('Not product found for id '.$product->getId());
        }

        $this->manager->remove($product);
        $this->manager->flush();

        return $this->redirectToRoute('app_product_index');
    }

    /**
     * @Route("/products/{id}/edit",name="app_product_edit")
     */
    public  function editProduct(int $id, Request $request,ProductHandler $handler) {
        $product = $this->repository->findOneBy(['id' => $id]);

        if ($handler->handle($request,$product)) {

            $this->addFlash('success', 'Yessss All Done !! Your Product Updated ... ');

            return $this->redirectToRoute('app_product_index', [
                'id' => $product->getId()
            ]);
        }
        return $this->render('product/edit.html.twig', [
            'form' => $handler->createView()
        ]);
    }
}
