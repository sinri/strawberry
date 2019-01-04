<?php
/**
 * Created by PhpStorm.
 * User: sinri
 * Date: 2019-01-04
 * Time: 23:58
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Strawberry.php';

// php Strawberry.php [ConfigFile] [StoreDir] [Time]

if (php_sapi_name() != 'cli') {
    exit("Run this in cli!" . PHP_EOL);
}
if ($argc < 4) {
    exit("Usage: php Strawberry.php [ConfigFile] [StoreDir] [Time]" . PHP_EOL);
}
//try {
    $configFile = $argv[1];
    $storeDir = $argv[2];
    $warnTime = $argv[3];

    $strawberry = new \sinri\strawberry\Strawberry($configFile, $warnTime, $storeDir);

    $strawberry->checkFullProcessList();

//} catch (Exception $e) {
//    exit("Exception: " . $e->getMessage() . PHP_EOL);
//}
