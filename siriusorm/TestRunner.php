<?php

require __DIR__ . '/SiriusOrmTestSuite.php';

$time = microtime(true);
$memory = memory_get_usage();
$test = new SiriusOrmTestSuite();
$test->initialize();
$test->run();
echo sprintf(" %11s | %6.2f |\n", number_format(memory_get_usage(true) - $memory), (microtime(true) - $time));
