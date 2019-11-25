<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Psr\Container\ContainerInterface;

/**
 * Создает компонент EntityManager
 * Class EntityManagerProvider
 */
class EntityManagerProvider implements ProviderInterface
{
    /**
     * Возвращает настроенный компонент \Doctrine\ORM\EntityManager
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html
     * @return EntityManager
     * @throws ORMException
     */
    static public function create(ContainerInterface $container): EntityManager
    {
        // Создадим простоую Doctrine ORM конфигурацию для анатаций.
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__ . "/../../src"),
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );
        // или, если мы хотим использовать xml\yaml
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

        // конфигурационный параметры базы данных
        $conn = config('entityManager');

        // получаем EntityManager
        $entityManager = EntityManager::create($conn, $config);

        // вывод SQL запросов для дебага и профилинга
        if ($conn['echoSQLLog']) {
            $sqlLogger = new EchoSQLLogger();
            $entityManager->getConfiguration()->setSQLLogger($sqlLogger);
        }
        return $entityManager;
    }
}