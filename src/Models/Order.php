<?php

namespace App\Models;

use Doctrine\Common\Collections\ArrayCollection;
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
    private $id;

    /**
     * @var  int статус заказа, по умолчанию Новый
     * @ORM\Column(type="integer")
     */
    private $status = self::STATUS_NEW;

    /**
     * Позиции заказа
     * @var OrderItem[]
     * @ORM\OneToMany(targetEntity="\App\Models\OrderItem", mappedBy="order")
     */
    private $orderItems;

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
     * @see self::STATUS_NEW
     * @see self::STATUS_PAYED
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Установить статус заказаз
     * @param $status int статус заказа
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function calculateSumm(): float
    {
        $summ = 0;
        $items = $this->getOrderItems();

        foreach ($items as $item) {
            $summ += $item->getGood()->getPrice();
        }

        return $summ;
    }

    /**
     * Возвращает массив позиций заказа
     * @return OrderItem[]
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