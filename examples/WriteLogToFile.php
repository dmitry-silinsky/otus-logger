<?php

use Otus\Logger\Handlers\FileHandler;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$handlers = new SplObjectStorage();
$handlers->attach(
    new FileHandler([
        'isEnabled' => true,
        'path' => 'examples/logs/otus_log',
    ])
);

$logger = new \Otus\Logger\Logger($handlers);
$logger->info("Info message");
$logger->alert("Alert message");
$logger->error("Error message");
$logger->debug("Debug message");
$logger->notice("Notice message");
$logger->warning("Warning message");
$logger->critical("Critical message");
$logger->emergency("Emergency message");
