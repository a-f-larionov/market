<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;


/**
 * Модель позиции заказа
 * Class OrderItem
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class OrderItem
{
    /**
     * @var int id позиции заказа
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @var int id заказа.
     * @ORM\Column(type="integer")
     */
    private int $orderId;

    /**
     * @var Order Заказ
     * @ORM\ManyToOne(targetEntity="App\Models\Order", inversedBy="orderItems")
     * @ORM\JoinColumn(name="orderId", referencedColumnName="id")
     */
    private Order $order;

    /**
     * @var int id товара
     * @ORM\Column(type="integer")
     */
    protected int $goodId;

    /**
     * @var Good Товар
     * @ORM\ManyToOne(targetEntity="App\Models\Good")
     * @ORM\JoinColumn(name="goodId", referencedColumnName="id")
     */
    private Good $good;

    /**
     * Получить id позиции товара
     * @return int id позиции товара
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Привязать заказ
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Получить товар
     * @return Good|null
     */
    public function getGood(): Good
    {
        return $this->good;
    }

    /**
     * Привязать товар
     * @param Good $good
     */
    public function setGood(Good $good): void
    {
        $this->good = $good;
    }
}
