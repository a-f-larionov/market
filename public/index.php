<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernel;
use App\Exceptions\UserRequestErrorException;

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

/** @var HttpKernel $kernel */
$kernel = app()->get('kernel');

$request = Request::createFromGlobals();

try {
    $response = $kernel->handle($request);
} catch (NotFoundHttpException $e) {
    $response = new Response("", Response::HTTP_NOT_FOUND);
} catch (UserRequestErrorException $e) {
    $response = new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
} catch (Exception $e) {
    throw $e;
}

$response->send();
