<?php

require __DIR__ . '/PHPFUI_ORMTestSuite.php';

$time = microtime(true);
$memory = memory_get_usage(true);
$test = new PHPFUI_ORMTestSuite();
$test->initialize();
$test->run();
echo sprintf(" %11s | %6.2f |\n", number_format(memory_get_usage(true) - $memory), (microtime(true) - $time));

// print table counts

//$tables = \PHPFUI\ORM\Table::getAllTables();
//foreach ($tables as $table)
//	{
//	echo $table->getTableName() . ' - ' . $table->count() . "\n";
//	}
