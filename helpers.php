<?php

/**
 * Простейшая версия конфигурации.
 * @param string|null $name
 * @param null $default
 * @return mixed|null
 */
function config(string $name = null, $default = null)
{
    static $config;

    if (!$config) {
        $config = require __DIR__ . '/config.php';
    }

    if (is_null($name)) {
        return $config;
    }

    return $config[$name] ?? $default;
}