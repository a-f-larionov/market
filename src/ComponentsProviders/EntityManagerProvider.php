<?php

namespace App\ComponentsProviders;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Создает компонент EntityManager
 * Class EntityManagerProvider
 */
class EntityManagerProvider implements ComponentInterface
{
    /**
     * Возвращает настроенный компонент \Doctrine\ORM\EntityManager
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html
     * @return EntityManager
     */
    static public function getComponent(): EntityManager
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
            $sqlLogger = new \Doctrine\DBAL\Logging\EchoSQLLogger();
            $entityManager->getConfiguration()->setSQLLogger($sqlLogger);
        }
        return $entityManager;
    }
}