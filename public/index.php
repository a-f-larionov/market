<?php

use \Symfony\Component\HttpFoundation\Request;

/**
 * Этот файл - точка входа.
 */

/**
 * Подключаем автозагрузчик от composer.
 * @see https://getcomposer.org/
 * @see https://www.php-fig.org/psr/psr-4/
 */
require_once __DIR__ . '/../vendor/autoload.php';

/** Бутстрап фреймворка. */
require_once __DIR__ . '/../bootstrap.php';

/**
 *  Возьмем запрос клиента.
 *  Направим его для обработки ядру приложения.
 *  Затем отправим ответ клиенту.
 */

/** @var \Symfony\Component\HttpKernel\HttpKernel $kernel */
$kernel = app()->get('kernel');

$request = Request::createFromGlobals();

$response = $kernel->handle($request);

$response->send();
