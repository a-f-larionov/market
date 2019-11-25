<?php

namespace App\TestDataProviders\Interfaces;

interface GoodsTestDataProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getPrice(): float;
}