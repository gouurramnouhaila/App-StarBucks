<?php


namespace App\Handler;


use App\Entity\Product;
use App\Form\ProductType;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductHandler extends AbstractHandler
{

    private  $manager;
    /**
     * @var UploaderHelper
     */
    private  $uploaderHelper;

    public function __construct(EntityManagerInterface $manager,UploaderHelper $uploaderHelper)
    {
        $this->manager = $manager;
        $this->uploaderHelper = $uploaderHelper;
    }


    /**
     * @inheritDoc
     */
    protected function getFormType(): string
    {
        return ProductType::class;
    }

    /**
     * @inheritDoc
     */
    protected function process($data): void
    {
        $form = $this->getForm();

        /*** @var UploadedFile $uploadImage */
        $uploadImage = $form['upload_image']->getData();

        if($uploadImage) {
            $newFileName = $this->uploaderHelper->uploadImage($uploadImage);
            /** @var $data Product */
            $data->setImage($newFileName);
        }

        $this->manager->persist($data);
        $this->manager->flush();
    }
}