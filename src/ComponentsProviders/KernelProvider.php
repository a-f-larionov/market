<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentArgumentValueResolver;
use App\Core\AppComponentInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Router;

/**
 * Создает компонент HttpKernel.
 * Class KernelProvider
 * @package App\Components
 */
class KernelProvider implements AppComponentInterface
{
    /**
     * Создает ядро приложения.
     * @return HttpKernel
     */
    static public function getComponent(): HttpKernel
    {
        $eventDispatcher = new EventDispatcher();

        /** @var Router $router */
        $router = app()->get('router');

        $eventDispatcher->addSubscriber(new RouterListener($router->getMatcher(), new RequestStack()));

        $controllerResolver = new ControllerResolver();

        $argumentValueResolvers = ArgumentResolver::getDefaultArgumentValueResolvers();
        array_push($argumentValueResolvers, new AppComponentArgumentValueResolver());
        $argumentsResolver = new ArgumentResolver(null, $argumentValueResolvers);

        $kernel = new HttpKernel($eventDispatcher, $controllerResolver, new RequestStack(), $argumentsResolver);

        return $kernel;
    }
}