<?php

namespace App;

use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use App\Exceptions\UserRequestErrorException;

/**
 * Class App
 */
class App
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * Создать приложение
     * @param ContainerInterface $container
     * @return App
     */
    public static function create(ContainerInterface $container): App
    {
        $app = $container->make(self::class);

        return $app;
    }

    /**
     * App constructor.
     * @param ContainerInterface $container
     * @param RouterInterface $router
     */
    public function __construct(ContainerInterface $container, RouterInterface $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * Обработать http-запрос клинета
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function handle(Request $request): Response
    {
        $this->container->set(Request::class, $request);

        try {

            $params = $this->router->match($request->getPathInfo());

            if (!is_callable($params['_controller'])) {
                throw new Exception("Controller must be callable.");
            }

            $response = $this->container->call($params['_controller'], $params);
        } catch (ResourceNotFoundException $e) {
            $response = new Response("", Response::HTTP_NOT_FOUND);
        } catch (UserRequestErrorException $e) {
            $response = new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}