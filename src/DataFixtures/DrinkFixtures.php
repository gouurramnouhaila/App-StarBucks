<?php

namespace App\DataFixtures;

use App\Factory\DrinkFactory;
use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DrinkFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        DrinkFactory::createMany(10,function () {
            return [
                'product' => ProductFactory::random()
            ];
        });

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 3;
    }
}
