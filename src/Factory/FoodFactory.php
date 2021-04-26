<?php

namespace App\Factory;

use App\Entity\Food;
use App\Repository\FoodRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Food|Proxy createOne(array $attributes = [])
 * @method static Food[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Food|Proxy find($criteria)
 * @method static Food|Proxy findOrCreate(array $attributes)
 * @method static Food|Proxy first(string $sortedField = 'id')
 * @method static Food|Proxy last(string $sortedField = 'id')
 * @method static Food|Proxy random(array $attributes = [])
 * @method static Food|Proxy randomOrCreate(array $attributes = [])
 * @method static Food[]|Proxy[] all()
 * @method static Food[]|Proxy[] findBy(array $attributes)
 * @method static Food[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Food[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FoodRepository|RepositoryProxy repository()
 * @method Food|Proxy create($attributes = [])
 */
final class FoodFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'price' => self::faker()->numberBetween(20,200),
            'ingredients' => self::faker()->text
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Food $food) {})
        ;
    }

    protected static function getClass(): string
    {
        return Food::class;
    }
}
