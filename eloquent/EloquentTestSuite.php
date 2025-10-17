<?php

require_once __DIR__ . '/../AbstractTestSuite.php';

class EloquentTestSuite extends AbstractTestSuite
{
    /*
     * @var $capsule Illuminate\Database\Capsule\Manager
     */
    protected $capsule = null;

    /**
     * @var Product
     */
    protected $product;

    function initialize()
    {
        $loader = require_once "vendor/autoload.php";

        $this->capsule = new Illuminate\Database\Capsule\Manager;

        $this->capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);

        $this->con = $this->capsule->getConnection()->getPdo();

        // Set the event dispatcher used by Eloquent models... (optional)
        $this->capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container()));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();

        $loader->add('', __DIR__ . '/models');
        $this->initTables();
    }

    function clearCache()
    {

    }

    function beginTransaction()
    {
        $this->capsule->getConnection()->beginTransaction();
    }

    function commit()
    {
        $this->capsule->getConnection()->commit();
    }

    function insert($i)
    {
        /**
         * Eloquent way
         *
         * 1. Save parents first (belongs to)
         * 2. Associate parents with model
         * 3. Save main model
         * 4. Save children (has many or belongs to many)
         */
        $category = new Category([
            'name' => 'Category #c' . $i
        ]);
        $category->save();

        $product = new Product([
            'name'  => 'Product #' . $i,
            'sku'   => 'SKU #' . $i,
            'price' => sqrt(1000 + $i * 100),
        ]);

        $product->category()->associate($category);

        $product->save();

        $product->images()->save(new Image([
            'path' => 'image_' . $i . '.jpg'
        ]));

        $product->tags()->saveMany([
            new Tag(['name' => 'Tag #t1_' . $i]),
            new Tag(['name' => 'Tag #t2_' . $i])
        ]);

        $this->products[] = $product->id;

        return $product;
    }

    public function test_insert()
    {
        $product = $this->insert(0);
        $product = Product::find($product->id);
        $this->assertNotNull($product, 'Product not found');
        $this->assertNotNull($product->category_id, 'Category was not associated with the product');
        $this->assertNotNull($product->images[0]->path, 'Image not present');
        $this->assertNotNull($product->tags[0]->name, 'Tag not present');
    }

    function prepare_update()
    {
        $this->insert(0);
        $this->product = Product::with('category', 'tags', 'images')->find(1);
    }

    function update($i)
    {
        $this->product->name            = 'New product name ' . $i;
        $this->product->category->name  = 'New category name ' . $i;
        $this->product->images[0]->path = 'new_path_' . $i . '.jpg';
        $this->product->tags[0]->name   = 'New tag name ' . $i;
        $this->product->push();
    }

    function test_update()
    {
        $this->product->name            = 'New product name';
        $this->product->category->name  = 'New category name';
        $this->product->images[0]->path = 'new_path.jpg';
        $this->product->tags[0]->name   = 'New tag name';
        $this->product->push();

        $product = Product::with('category', 'tags', 'images')->find(1);

        $this->assertEquals('New product name', $product->name);
        $this->assertEquals('New category name', $product->category->name);
        $this->assertEquals('new_path.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name', $product->tags[0]->name);
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }

    function find($i)
    {
        Product::find($i);
    }

    function test_find()
    {
        $product = Product::find(1);
        $this->assertEquals('New product name ' . (self::NB_TEST - 1), $product->name); // changed by "update"
    }

    function complexQuery($i)
    {
        Product::join('categories', 'categories.id', 'products.category_id')
               ->where('products.id', '>', 50)
               ->where('categories.id', '<', 300)
               ->count();
    }

    function test_complexQuery()
    {
        $this->assertEquals(249, Product::join('categories', 'categories.id', 'products.category_id')
                                        ->where('products.id', '>', 50)
                                        ->where('categories.id', '<', 300)
                                        ->count());
    }

    function relations($i)
    {
        $products = Product::with('category', 'tags', 'images')
                           ->where('price', '>', 50)
                           ->limit(10)
                           ->get();
        foreach ($products as $product) {

        }
    }

    function test_relations()
    {
        $product = Product::with('category', 'tags', 'images')->find(1);
        $lastRun       = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->name);
        $this->assertEquals('New category name ' . $lastRun, $product->category->name);
        $this->assertEquals('new_path_' . $lastRun . '.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name ' . $lastRun, $product->tags[0]->name);
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }
}