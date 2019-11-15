<?php
/**
 * Этот файл является необходимым для работы консольной утилиты
 * vendor/bin/doctrine
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/tools.html#command-overview
 */
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'bootstrap.php';

return ConsoleRunner::createHelperSet(app()->get(EntityManager::class));