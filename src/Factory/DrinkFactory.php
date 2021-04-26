<?php

namespace App\Factory;

use App\Entity\Drink;
use App\Repository\DrinkRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Drink|Proxy createOne(array $attributes = [])
 * @method static Drink[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Drink|Proxy find($criteria)
 * @method static Drink|Proxy findOrCreate(array $attributes)
 * @method static Drink|Proxy first(string $sortedField = 'id')
 * @method static Drink|Proxy last(string $sortedField = 'id')
 * @method static Drink|Proxy random(array $attributes = [])
 * @method static Drink|Proxy randomOrCreate(array $attributes = [])
 * @method static Drink[]|Proxy[] all()
 * @method static Drink[]|Proxy[] findBy(array $attributes)
 * @method static Drink[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Drink[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DrinkRepository|RepositoryProxy repository()
 * @method Drink|Proxy create($attributes = [])
 */
final class DrinkFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'price' => self::faker()->numberBetween(30,150),
            'ingredients' => self::faker()->text
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Drink $drink) {})
        ;
    }

    protected static function getClass(): string
    {
        return Drink::class;
    }
}
