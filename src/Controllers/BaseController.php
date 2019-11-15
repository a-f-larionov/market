<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Базовый контроллер, предоставляет:
 * - методы для формирования ответов клиенту.
 * Class BaseController
 * @package App\Controllers
 */
class BaseController
{
    /**
     * Формирует успешный ответ.
     * Rод ответа: 200 - OK
     * @param $content string содержимое(бади) ответа
     * @return Response
     */
    public function responseWithSuccess(string $content = ""): Response
    {
        return new Response($content, Response::HTTP_OK);
    }

    /**
     * Формирует ответ об ошибке.
     * Код ошибки: 400 - Bad Request
     * @param string $content содержимое(бади) ответа
     * @return Response
     */
    public function responseWithFailed(string $content = ""): Response
    {
        return new Response($content, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Формирует JSON ответ.
     * @param mixed $data
     * @return Response
     */
    public function responseJSON($data): Response
    {
        return new Response(json_encode($data), Response::HTTP_OK);
    }
}