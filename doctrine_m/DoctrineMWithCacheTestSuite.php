<?php

require_once __DIR__ . '/DoctrineMTestSuite.php';

class DoctrineMWithCacheTestSuite extends DoctrineMTestSuite
{
    private $cache = null;

	function initialize()
	{
		parent::initialize();
	}

}