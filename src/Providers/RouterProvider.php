<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Router;

/**
 * Class RouterProvider
 * @package App\Providers
 */
class RouterProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     * @return Router
     */
    public static function create(ContainerInterface $container): Router
    {
        $fileLocator = new FileLocator([__DIR__ . '/']);
        $loader = new PhpFileLoader($fileLocator);
        $router = new Router($loader, __DIR__ . '/../../routes.php');
        return $router;
    }
}