<?php
/**
 * Этот файл является необходимым для работы консольной утилиты
 * vendor/bin/doctrine
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/tools.html#command-overview
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require_once __DIR__ . '/bootstrap.php';

/** @var EntityManager $em */
$em = $container->get(EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($em);