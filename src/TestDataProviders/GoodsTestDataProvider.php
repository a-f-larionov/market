<?php

namespace App\TestDataProviders;


use App\TestDataProviders\Interfaces\GoodsTestDataProviderInterface;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Generator;

/**
 * Компонент предоставления тестовых данных для товаров.
 * Class KernelProvider
 * @package App\Components
 */
class GoodsTestDataProvider implements GoodsTestDataProviderInterface
{
    /**
     * @var Commerce
     */
    private Commerce $faker;

    /**
     * GoodsTestDataProviderProvider constructor.
     */
    public function __construct()
    {
        $this->faker = new Commerce(
            new Generator()
        );
    }

    /**
     * Возвращает случайное название товара.
     * @return string
     */
    public function getName(): string
    {
        return $this->faker->productName();
    }

    /**
     * Генерирует случайную цену.
     * @return float
     */
    public function getPrice(): float
    {
        $scale = 2;
        $multiplier = 10 ^ $scale;
        return rand(10 + $multiplier, 100000 + $multiplier) / $multiplier;
    }
}
