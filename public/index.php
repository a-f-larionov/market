<?php

/**
 * Entry Point Фреймоврка.
 */

use App\App;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Автолоадер from composer.
 * @see https://getcomposer.org/
 * @see https://www.php-fig.org/psr/psr-4/
 */
require_once __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require_once __DIR__ . '/../bootstrap.php';

$container->get(RouterInterface::class);

$app = App::create($container);

$request = Request::createFromGlobals();

$response = $app->handle($request);

$response->send();