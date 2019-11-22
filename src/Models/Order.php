<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;


/**
 * Class Order Заказы
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * Статус заказа: Новый
     */
    private const STATUS_NEW = 1;

    /**
     * Статус заказа: Оплачен
     */
    private const STATUS_PAYED = 2;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @var  int статус заказа, по умолчанию Новый
     * @ORM\Column(type="integer")
     */
    private int $status = self::STATUS_NEW;

    /**
     * Позиции заказа
     * @var Collection|OrderItem[]
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private ?Collection $orderItems = null;

    /**
     * Order constructor.
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/association-mapping.html#one-to-many-bidirectional
     */
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    /**
     * Получить id заказа
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Получить статус товара
     * @return int
     * @see self::STATUS_PAYED
     * @see self::STATUS_NEW
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Возвращает клиенто-безопасный массив.
     * @return array
     */
    public function mapToArray(): array
    {
        return [
            'id' => $this->getId(),
            'status' => $this->getStatus()
        ];
    }

    /**
     * Находится ли заказ в статусе Новый?
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->getStatus() == self::STATUS_NEW;
    }

    /**
     * Раситывает сумму заказа.
     * @return float
     */
    public function calculateSum(): float
    {
        $sum = 0;
        $items = $this->getOrderItems();

        foreach ($items as $item) {
            $sum += $item->getGood()->getPrice();
        }

        return $sum;
    }

    /**
     * Возвращает массив позиций заказа
     * @return PersistentCollection|OrderItem[]
     */
    public function getOrderItems(): PersistentCollection
    {
        return $this->orderItems;
    }

    /**
     * Установить статус: оплачено
     */
    public function setStatusPayed(): void
    {
        $this->status = self::STATUS_PAYED;
    }
}