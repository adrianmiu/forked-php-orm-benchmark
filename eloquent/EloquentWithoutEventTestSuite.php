<?php

require_once __DIR__ . '/EloquentTestSuite.php';

class EloquentWithoutEventTestSuite extends EloquentTestSuite
{
 	function initialize()
	{
        $loader = require_once "vendor/autoload.php";

        $this->capsule = new Illuminate\Database\Capsule\Manager ;

        $this->capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  =>  ':memory:',
        ]);

        $this->con = $this->capsule->getConnection()->getPdo();

        // Set the event dispatcher used by Eloquent models... (optional)
        //$this->capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container()));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();

        $loader->add('', __DIR__ . '/models');
		$this->initTables();
	}
}