<?php

namespace App\Controllers;

use App\Managers\GoodsManager;
use App\Managers\Interfaces\GoodsManagerInterface;
use App\Models\Good;
use App\Providers\GoodsTestDataProviderProvider;
use App\Repositories\GoodsRepository;
use App\TestDataProviders\Interfaces\GoodsTestDataProviderInterface;
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
     * @param GoodsTestDataProviderProvider $testDataProvider
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createTestPack(
        GoodsManagerInterface $goodsManager,
        GoodsTestDataProviderInterface $testDataProvider
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
     * @param GoodsRepository $goodsRepository
     * @return Response
     */
    public function listAll(int $page, GoodsRepository $goodsRepository): Response
    {
        if ($page < 1) {
            return $this->responseWithFailed("Укажите page.");
        }

        $page--;
        $offset = $page * (self::GOODS_LIST_PAGE_SIZE);

        $all = $goodsRepository->findBy([], null, self::GOODS_LIST_PAGE_SIZE, $offset);

        $all = array_map(fn (Good $good) => $good->mapToArray(), $all);

        return $this->responseJSON($all);
    }
}