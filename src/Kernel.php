<?php

namespace App;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Ядро фреймворка.
 * Class Kernel
 * @package App
 */
class Kernel
{
    /**
     * Обрабатывает запрос клиента
     * Выполняет роутинг и направляет запрос к нужному контролеру или выполняет анонимную функцию.
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        /** @var Router $router */
        $router = app()->get('router');

        try {
            $params = $router->match($request->getPathInfo());

            $result = app()->call($params['_controller'], $params);

            $response = $this->handleResult($result);

        } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $exception) {

            $response = new \Symfony\Component\HttpFoundation\Response("", 404, []);
        }

        return $response;
    }

    /**
     * Обрабатываем ответ.
     * Для простоты можно использовать
     * true\false Response и string
     * @param mixed $result
     * @return Response
     */
    private function handleResult($result): Response
    {
        if (true === $result) {
            return new Response("OK", 200);
        }
        if (false === $result) {
            return new Response("FAILED", 200);
        }
        if ($result instanceof Response) {
            return $result;
        }
        if (is_string($result)) {
            return new Response($result, 200);
        }
        throw new Exception("Controller must return true, string or Response.");
    }
}
