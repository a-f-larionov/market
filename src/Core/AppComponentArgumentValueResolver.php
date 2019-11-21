<?php

namespace App\Core;

use DI\DependencyException;
use DI\NotFoundException;
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
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return bool
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return (bool)app()->get($argument->getType());
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield app()->get($argument->getType());
    }
}