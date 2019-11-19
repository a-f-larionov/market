<?php

namespace App\Controllers;

use App\ComponentsProviders\TestGoodsProvider;
use App\Models\Good;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер товаров.
 * Class GoodsController
 * @package App\Controllers
 */
class  GoodsController extends BaseController
{
    /**
     * Размер тестового пака товара.
     */
    private const  TEST_PACK_SIZE = 20;

    /**
     * Создает self::TEST_PACK_SIZE тестовых товаров со случайными названиями и ценами.
     * @param EntityManager $entityManager
     * @param TestGoodsProvider $testDataProvider
     * @return Response
     */
    public function createTestPack(EntityManager $entityManager, TestGoodsProvider $testDataProvider): Response
    {
        for ($i = 0; $i < self::TEST_PACK_SIZE; $i++) {

            $good = new Good();
            $good->setName($testDataProvider->getName());
            $good->setPrice($testDataProvider->getPrice());

            $entityManager->persist($good);
            $entityManager->flush();
        }

        return $this->responseWithSuccess("Товаров " . self::TEST_PACK_SIZE . " создано.");
    }

    /**
     * Возвращает список всех товаров.
     * @param int $page номер страницы, начиная с 1-цы
     * @param Request $request
     * @param EntityManager $entityManager
     * @return Response
     */
    public function listAll(int $page, Request $request, EntityManager $entityManager): Response
    {
        if ($page < 1) {
            return $this->responseWithFailed("Укажите page.");
        }

        $pageSize = 10;
        $page--;
        $offset = $page * ($pageSize);

        $repository = $entityManager->getRepository(Good::class);
        $all = $repository->findBy([], null, $pageSize, $offset);

        $all = array_map(function (Good $item) {
            return $item->mapToArray();
        }, $all);

        return $this->responseJSON($all);
    }
}