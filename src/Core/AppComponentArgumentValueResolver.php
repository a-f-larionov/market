<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Класс для разрешения аргументов контроллеров приложения.
 * Позволяет реализовать dependency injection для контроллеров.
 * Class AppComponentArgumentValueResolver
 * @package App\Core
 */
class AppComponentArgumentValueResolver implements ArgumentValueResolverInterface
{

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if (app()->get($argument->getType())) {
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield app()->get($argument->getType());
    }
}