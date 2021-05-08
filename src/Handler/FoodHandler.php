<?php


namespace App\Handler;


use App\Form\FoodType;
use Doctrine\ORM\EntityManagerInterface;

class FoodHandler extends AbstractHandler
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
     * @inheritDoc
     */
    protected function getFormType(): string
    {
        return FoodType::class;
    }

    /**
     * @inheritDoc
     */
    protected function process($data): void
    {
        $this->manager->persist($data);
        $this->manager->flush();
    }
}