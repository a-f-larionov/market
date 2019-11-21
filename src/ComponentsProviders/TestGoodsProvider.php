<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentInterface;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Generator;

/**
 * Компонент предоставления тестовых данных для товаров.
 * Class KernelProvider
 * @package App\Components
 */
class TestGoodsProvider implements AppComponentInterface
{
    /**
     * @var Commerce
     */
    private Commerce $faker;

    /**
     * Создает сам себя(провайдер тестовых данных товаров).
     * @return TestGoodsProvider
     */
    static public function getComponent(): TestGoodsProvider
    {
        return new self;
    }

    /**
     * TestGoodsProvider constructor.
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
