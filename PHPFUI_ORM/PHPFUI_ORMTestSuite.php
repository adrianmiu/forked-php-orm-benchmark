<?php

require_once "vendor/autoload.php";
require_once __DIR__ . '/../AbstractTestSuite.php';

class Migration extends \PHPFUI\ORM\Migration
	{
	public function description() : string
		{
		return 'Create test db';
		}

	public function up() : bool
		{
		$this->runSQL('CREATE TABLE [product] (
			[product_id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
			[name] VARCHAR(255)  NOT NULL,
			[sku] VARCHAR(24)  NOT NULL,
			[price] FLOAT,
			[category_id] INTEGER,
			FOREIGN KEY (category_id) REFERENCES category(id))');

		$this->runSQL('CREATE TABLE [category] (
			[category_id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
			[name] VARCHAR(128)  NOT NULL)');

		$this->runSQL('CREATE TABLE [image] (
			[image_id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
			[imageable_id] INTEGER,
			[imageable_type] VARCHAR(128),
			[path] VARCHAR(128)  NOT NULL)');

		$this->runSQL('CREATE TABLE [tag](
			[tag_id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
			[name] VARCHAR(128)  NOT NULL)');

		$this->runSQL('CREATE TABLE [product_tag] (
			[product_tag_id] INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,
			[product_id] INTEGER,
			[tag_id] INTEGER,
			[position] INTEGER)');

		return true;
		}

	public function down() : bool
		{
		$this->dropTable('product');
		$this->dropTable('product_tag');
		$this->dropTable('tag');
		$this->dropTable('category');
		$this->dropTable('image');

		return true;
		}

	}

class PHPFUI_ORMTestSuite extends AbstractTestSuite
  {
  private ?\PHPFUI\ORM\Transaction $transaction = null;

	public function initTables()
		{
		$migration = new \Migration();
		$migration->down();
		$migration->up();

// This code generates the models.  It is not used for benchmarks, but should be run when upgrading to a new version of PHPFUI/ORM

//	 	$generator = new \PHPFUI\ORM\Tool\Generate\CRUD();
//
//	 	$tables = \PHPFUI\ORM::getTables();
//
//	 	if (! \count($tables))
//	 		{
//	 		echo "No tables found. Check your database configuration settings.\n";
//
//	 		exit;
//	 		}
//
//	 	foreach ($tables as $table)
//	 		{
//	 		if ($generator->generate($table))
//	 			{
//	 			echo "{$table}\n";
//	 			}
//	 		}
		}

	public function initialize()
    {
		\PHPFUI\ORM::$namespaceRoot = __DIR__;
		\PHPFUI\ORM::$recordNamespace = 'App\\Record';
		\PHPFUI\ORM::$tableNamespace = 'App\\Table';
		\PHPFUI\ORM::$migrationNamespace = 'App\\Migration';
		\PHPFUI\ORM::$idSuffix = '_id';

		\PHPFUI\ORM::addConnection(new \PHPFUI\ORM\PDOInstance('sqlite::memory:'));

		$this->initTables();
    }

  public function clearCache()
    {
    }

  public function beginTransaction()
    {
    $this->transaction = new \PHPFUI\ORM\Transaction();
    }

  public function commit()
    {
    $this->transaction->commit();
    }

  public function insert($i)
    {
    $product = new \App\Record\Product();
  	$product->name  = 'Product #' . $i;
    $product->sku   = 'SKU #' . $i;
    $product->price = sqrt(1000 + $i * 100);

    $category = new \App\Record\Category();
    $category->name = 'Category #c' . $i;
    $product->category = $category;

  	$image = new \App\Record\Image();
    $image->path = "image_{$i}.jpg";
  	$product->images = $image;

		$tag1 = new \App\Record\Tag();
		$tag1->name = 'Tag #t1_' . $i;
		$tag1->insert();

		$tag2 = new \App\Record\Tag();
		$tag2->name = 'Tag #t2_' . $i;
		$tag2->insert();

		$product->tags = $tag1;
		$product->tags = $tag2;

		$product->insert();

		return $product;
    }

  public function test_insert()
    {
		$product = $this->insert(0);
		$productInserted = new \App\Record\Product($product->product_id);
		$this->assertEquals(true, $productInserted->loaded(), 'Product not found');
		$this->assertNotNull($productInserted->category_id ?? null, 'Category was not associated with the product');
		$this->assertNotNull($productInserted->images->current()->path ?? null, 'Image not present');
		$this->assertNotNull($productInserted->tags->current()->name ?? null, 'Tag not present');
    }

  public function update($i)
    {
		$product = new \App\Record\Product($i);

		$product->name = 'New product name ' . $i;
		$product->update();

    $category = $product->category;
		$category->name = 'New category name ' . $i;
		$category->update();

    $image = $product->images->current();
		$image->path = 'new_path_' . $i . '.jpg';
		$image->update();

    $tag = $product->tags->current();
		$tag->name   = 'New tag name ' . $i;
    $tag->update();

		return $product;
    }

  public function test_update()
    {
		$product = $this->update(1);

    $this->assertEquals('New product name 1', $product->name);
    $this->assertEquals('New category name 1', $product->category->name);
    $this->assertEquals('new_path_1.jpg', $product->images->current()->path);
		$tags = $product->tags;
    $this->assertEquals('New tag name 1', $tags->current()->name);
		$tags->next();
    $this->assertEquals('Tag #t2_0', $tags->current()->name);
    }

  public function find($i)
    {
    return new \App\Record\Product($i);
    }

  public function test_find()
    {
    $product = $this->find(self::NB_TEST - 1);
    $this->assertEquals('New product name ' . (static::NB_TEST - 1), $product->name); // changed by "update"
    }

  public function complexQuery($i)
    {
		$productTable = new \App\Table\Product();
		$productTable->addJoin('category');
		$condition = new \PHPFUI\ORM\Condition('product.product_id', 50, new \PHPFUI\ORM\Operator\GreaterThan());
		$condition->and('category.category_id', 300, new \PHPFUI\ORM\Operator\LessThan());
		$productTable->setWhere($condition);

		return $productTable->count();
    }

  public function test_complexQuery()
    {
    $this->assertEquals(249, $this->complexQuery(0));
    }

  public function relations($i)
    {
    $productTable = new \App\Table\Product();
		$productTable->setWhere(new \PHPFUI\ORM\Condition('price', 50, new \PHPFUI\ORM\Operator\GreaterThan()));
		$productTable->setLimit(10);

		$count = 0;
		foreach ($productTable->getRecordCursor() as $product)
      {
			++$count;
      }

		return $count;
    }

  public function test_relations()
    {
		$lastRun = self::NB_TEST - 1;
		$product = new \App\Record\Product($lastRun);
		$this->assertEquals('New product name ' . $lastRun, $product->name);
		$this->assertEquals('New category name ' . $lastRun, $product->category->name);
		$this->assertEquals('new_path_' . $lastRun . '.jpg', $product->images->current()->path);
		$tags = $product->tags;
		$this->assertEquals('New tag name ' . $lastRun, $tags->current()->name);
		$tags->next();
		$this->assertEquals('Tag #t2_497', $tags->current()->name);
    }
  }