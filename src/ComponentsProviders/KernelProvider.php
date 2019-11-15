<?php

namespace App\ComponentsProviders;

use App\Kernel;

/**
 * Создает компонент ядра приложения.
 * Class KernelProvider
 * @package App\Components
 */
class KernelProvider implements ComponentInterface
{
    /**
     * Создает ядро приложения.
     * @return Kernel
     */
    static public function getComponent(): Kernel
    {
        return new Kernel();
    }
}