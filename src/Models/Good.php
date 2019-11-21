<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Модель товаров.
 * Class Good
 * @ORM\Entity
 * @ORM\Table(name="goods")
 */
class Good
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected ?int $id= null;

    /**
     * @var string название товара
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @var float цена товара
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $price;

    /**
     * Получить id товара
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Установить название товара
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Получить название товара
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Получить цену товара
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Установить цену товара
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Получить клиенто-безопасный массив.
     * @return array
     */
    public function mapToArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
        ];
    }
}