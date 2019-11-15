<?php

namespace App\ComponentsProviders;

use Symfony\Component\HttpFoundation\Request;

/**
 * Создает компонент Request из запроса клиента.
 * Это нам понадобиться для инджектов в методы контролеров.
 * Class RequestProvider
 * @package App\Components
 */
class RequestProvider implements ComponentInterface
{
    /**
     * Создает Request из запроса клиента.
     * @return Request
     */
    static public function getComponent(): Request
    {
        $request = Request::createFromGlobals();
        app()->set(Request::class, $request);
        app()->set('request', $request);

        return $request;
    }
}