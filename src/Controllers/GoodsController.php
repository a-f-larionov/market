<?php

namespace App\Controllers;

use App\ComponentsProviders\TestGoodsProvider;
use App\Managers\GoodsManager;
use App\Models\Good;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер товаров.
 * Class GoodsController
 * @package App\Controllers
 */
class  GoodsController extends BaseController
{
    /**
     * Размер страницы списка товаров.
     */
    private const GOODS_LIST_PAGE_SIZE = 100;

    /**
     * Размер тестового пака товара.
     */
    private const TEST_PACK_SIZE = 20;

    /**
     * Создает self::TEST_PACK_SIZE тестовых товаров со случайными названиями и ценами.
     * @param GoodsManager $goodsManager
     * @param TestGoodsProvider $testDataProvider
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createTestPack(
        GoodsManager $goodsManager,
        TestGoodsProvider $testDataProvider
    ): Response {

        for ($i = 0; $i < self::TEST_PACK_SIZE; $i++) {

            $goodsManager->create(
                $testDataProvider->getName(),
                $testDataProvider->getPrice()
            );
        }

        return $this->responseWithSuccess("Выполненна попытка создать " . self::TEST_PACK_SIZE . " товаров.");
    }

    /**
     * Возвращает список всех товаров.
     * @param int $page номер страницы, начиная с 1-цы
     * @param EntityManager $entityManager
     * @return Response
     */
    public function listAll(int $page, EntityManager $entityManager): Response
    {
        if ($page < 1) {
            return $this->responseWithFailed("Укажите page.");
        }

        $page--;
        $offset = $page * (self::GOODS_LIST_PAGE_SIZE);

        $repository = $entityManager->getRepository(Good::class);
        $all = $repository->findBy([], null, self::GOODS_LIST_PAGE_SIZE, $offset);

        $all = array_map(fn (Good $good) => $good->mapToArray(), $all);

        return $this->responseJSON($all);
    }
}