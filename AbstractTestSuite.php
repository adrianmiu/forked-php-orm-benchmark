<?php

require_once __DIR__ . '/sfTimer.php';

abstract class AbstractTestSuite
{
    /** @var PDO $con */
    protected $con;

    protected $products = array();

    const NB_TEST = 500;

    abstract function initialize();

    abstract function clearCache();

    abstract function beginTransaction();

    abstract function commit();

    abstract function insert($i);

    abstract function test_insert();

    abstract function update($i);

    abstract function test_update();

    abstract function find($i);

    abstract function test_find();

    abstract function complexQuery($i);

    abstract function test_complexQuery();

    abstract function relations($i);

    abstract function test_relations();

    public function initTables()
    {
        try {
            $this->con->exec('DROP TABLE [products]');
            $this->con->exec('DROP TABLE [products_tags]');
            $this->con->exec('DROP TABLE [tags]');
            $this->con->exec('DROP TABLE [categories]');
            $this->con->exec('DROP TABLE [images]');
        } catch (PDOException $e) {
            // do nothing - the tables probably don't exist yet
        }
        $this->con->exec('CREATE TABLE [products]
		(
			[id] INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
			[name] VARCHAR(255)  NOT NULL,
			[sku] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[category_id] INTEGER,
			FOREIGN KEY (category_id) REFERENCES categories(id)
		)');
        $this->con->exec('CREATE TABLE [categories]
		(
			[id] INTEGER PRIMARY KEY  AUTOINCREMENT,
			[name] VARCHAR(128)  NOT NULL
		)');
        $this->con->exec('CREATE TABLE [images]
		(
			[id] INTEGER PRIMARY KEY  AUTOINCREMENT,
			[imageable_id] INTEGER,
			[imageable_type] VARCHAR(128),
			[path] VARCHAR(128)  NOT NULL
		)');
        $this->con->exec('CREATE TABLE [tags]
		(
			[id] INTEGER PRIMARY KEY  AUTOINCREMENT,
			[name] VARCHAR(128)  NOT NULL
		)');
        $this->con->exec('CREATE TABLE [products_tags]
		(
			[id] INTEGER PRIMARY KEY AUTOINCREMENT,
			[product_id] INTEGER,
			[tag_id] INTEGER,
			[position] INTEGER
		)');
    }

    public function run()
    {
        $t1 = $this->runMethod('insert');
        $t2 = $this->runMethod('update');
        $t3 = $this->runMethod('find');
        $t4 = $this->runMethod('complexQuery');
        $t5 = $this->runMethod('relations');
        echo sprintf("| %32s | %6d | %6d | %6d | %6d | %7d |", str_replace('TestSuite', '', get_class($this)), $t1, $t2, $t3, $t4, $t5);
    }

    public function runMethod($methodName, $nbTest = self::NB_TEST)
    {
        // prepare method are used to isolate some operations outside the tests
        // for the getters test we isolate the retrieval of the object from the db
        $prepareMethod = 'prepare_' . $methodName;
        if (method_exists($this, $prepareMethod)) {
            $this->$prepareMethod();
        }

        $testMethod = 'test_' . $methodName;
        $this->$testMethod();

        $timer = new sfTimer();

        $this->clearCache();

        for ($i = 0; $i < $nbTest; $i++) {
            $this->$methodName($i);
        }
        $t = $timer->getElapsedTime();

        return $t * 1000;
    }

    public function assertEquals($expected, $actual, $message = null) {
        if ($expected != $actual) {
            throw new Exception($message ?? sprintf('%s is not the same %s', $expected, $actual));
        }
    }

    public function assertNotNull($actual, $message = null) {
        if (null == $actual) {
            throw new Exception($message ?? sprintf('%s is null or zero', $actual));
        }
    }
}
