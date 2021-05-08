<?php


namespace App\Handler;


use App\Form\DrinkType;
use Doctrine\ORM\EntityManagerInterface;

class DrinkHandler extends AbstractHandler
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
        return DrinkType::class;
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