<?php

namespace App\ComponentsProviders;

use \Symfony\Component\Config\FileLocator;
use \Symfony\Component\Routing\Loader\PhpFileLoader;
use \Symfony\Component\Routing\Router;

/**
 * Создает компонент роутера.
 * Class RouterProvider
 * @package App\Components
 */
class RouterProvider implements ComponentInterface
{
    /**
     * Создать роутер прочитать роут файл.
     * @return Router
     */
    static public function getComponent(): Router
    {
        $fileLocator = new FileLocator([__DIR__ . '/']);
        $loader = new PhpFileLoader($fileLocator);
        $router = new Router($loader, __DIR__ . '/../../routes.php');

        return $router;
    }
}