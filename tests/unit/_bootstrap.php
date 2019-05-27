<?php

error_reporting(-1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
setlocale(LC_ALL, 'en_US.utf-8');

date_default_timezone_set('UTC');
mb_internal_encoding('utf-8');
mb_substitute_character('none');

clearstatcache();

$root = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
define('APP_PATH', $root);

unset($root);

if (true !== function_exists('env')) {
    function env($key, $default = null)
    {
        if (defined($key)) {
            return constant($key);
        }

        return getenv($key) ?: $default;
    }
}

/**
 * Returns the output folder
 */
if (true !== function_exists('dataDir')) {
    /**
     * @param string $fileName
     *
     * @return string
     */
    function dataDir(string $fileName = '')
    {
        return codecept_data_dir() . $fileName;
    }
}

/**
 * Returns the output folder
 */
if (true !== function_exists('fixturesDir')) {
    /**
     * @param string $fileName
     *
     * @return string
     */
    function fixturesDir(string $fileName = '')
    {
        return codecept_data_dir('fixtures') . $fileName;
    }
}

/**
 * Returns the output folder
 */
if (true !== function_exists('outputDir')) {
    /**
     * @param string $fileName
     *
     * @return string
     */
    function outputDir(string $fileName = '')
    {
        return codecept_output_dir() . $fileName;
    }
}

/*******************************************************************************
 * Options
 *******************************************************************************/
/**
 * Return the libmemcached options
 */
if (true !== function_exists('getOptionsLibmemcached')) {
    /**
     * @return array
     */
    function getOptionsLibmemcached(): array
    {
        return [
            'client'  => [],
            'servers' => [
                [
                    'host'   => env('DATA_MEMCACHED_HOST', '127.0.0.1'),
                    'port'   => env('DATA_MEMCACHED_PORT', 11211),
                    'weight' => env('DATA_MEMCACHED_WEIGHT', 0),
                ],
            ],
        ];
    }
}

/**
 * Return the Redis options
 */
if (true !== function_exists('getOptionsRedis')) {
    /**
     * @return array
     */
    function getOptionsRedis(): array
    {
        return [
            'host'  => env('DATA_REDIS_HOST'),
            'port'  => env('DATA_REDIS_PORT'),
            'index' => env('DATA_REDIS_NAME'),
        ];
    }
}