#!/usr/bin/env php
<?php
/**
 * PHP 7 déclaration stricte
 */
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Hj\MergeCommand;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Application;

$logger = new Logger("console");
$output = "[%datetime%] %level_name% : %message%\n";
$formatter = new \Monolog\Formatter\LineFormatter($output);

try {
    $handler = new StreamHandler('php://stdout', Logger::DEBUG);
    $handler->setFormatter($formatter);
    $logger->pushHandler($handler);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

$application = new Application();
$application->add(new MergeCommand($logger));

try {
    $application->run();
} catch (Exception $e) {
    $logger->error($e->getMessage());
}