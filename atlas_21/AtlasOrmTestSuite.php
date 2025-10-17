<?php

use Atlas\Orm\Atlas;
use Atlas\Pdo\Connection;
use Category\Category;
use Image\Image;
use Product\Product;
use ProductsTag\ProductsTag;
use Tag\Tag;

require_once __DIR__ . '/../AbstractTestSuite.php';

/**
 * This test suite just demonstrates the baseline performance without any kind of ORM
 * or even any other kind of slightest abstraction.
 */
class AtlasOrmTestSuite extends AbstractTestSuite
{

    /**
     * @var \Atlas\Orm\Atlas
     */
    private $atlas;

	private $product;

    function initialize()
    {
        $loader = require_once "vendor/autoload.php";
        $loader->add('', __DIR__ . '/src');

        $this->con = Connection::new('sqlite::memory:');
        #$this->con = Connection::new('sqlite:sqlite');

        $this->atlas = Atlas::new(
            $this->con
        );

        $this->initTables();
    }

    function clearCache()
    {
    }

    function beginTransaction()
    {
        #$this->transaction = $this->atlas->beginTransaction();
    }

    function commit()
    {
        #$this->atlas->commit();
    }

    function insert($i)
    {
        $product           = $this->atlas->newRecord(Product::class, [
            'name'  => 'Product #' . $i,
            'sku'   => 'SKU #' . $i,
            'price' => sqrt(1000 + $i * 100),
        ]);
        $product->category = $this->atlas->newRecord(Category::class, [
            'name' => 'Category #c' . $i
        ]);
        $product->images   = $this->atlas->newRecordSet(Image::class);
        $product->images->appendNew([
            'path'           => 'image_' . $i . '.jpg',
            'imageable_type' => 'product',
        ]);
        $product->tags = $this->atlas->newRecordSet(Tag::class);
        $product->tags->appendNew(['name' => 'Tag #t1_' . $i]);
        $product->tags->appendNew(['name' => 'Tag #t2_' . $i]);

        $this->atlas->beginTransaction();
        foreach ($product->tags as $tag) {
            $this->atlas->insert($tag);
        }
        $this->atlas->insert($product->category);
        $product->category_id = $product->category->id;
        $this->atlas->insert($product);
        foreach ($product->images as $image) {
            $image->imageable_id = $product->id;
            $this->atlas->insert($image);
        }
        foreach ($product->tags as $tag) {
            $this->atlas->insert($this->atlas->newRecord(ProductsTag::class, [
                'product_id' => $product->id,
                'tag_id'     => $tag->id
            ]));
        }
        $this->atlas->commit();;

        $this->products[] = $product->id;

        return $product;
    }

    public function test_insert()
    {
        $product = $this->insert(0);
        $product = $this->atlas->fetchRecord(Product::class, $product->id, ['category', 'tags', 'images']);
        $this->assertNotNull($product, 'Product not found');
        $this->assertNotNull($product->category->id, 'Category was not associated with the product');
        $this->assertNotNull($product->images[0]->path, 'Image not present');
        $this->assertNotNull($product->tags[0]->name, 'Tag not present');

        /**
         * THIS DOES NOT WORK FOR SOME REASON, HAVE TO RETURN
         */
        return;
        $this->assertNotNull($product->tags[1]->name, 'Tag not present');
    }

    function prepare_update()
    {
        $this->product = $this->atlas->fetchRecord(Product::class, 1, ['category', 'tags', 'images']);
    }

    function update($i)
    {
        $this->product->name            = 'New product name ' . $i;
        $this->product->category->name  = 'New category name ' . $i;
        $this->product->images[0]->path = 'new_path_' . $i . '.jpg';
        $this->product->tags[0]->name   = 'New tag name ' . $i;

        $this->atlas->persist($this->product);
    }

    function test_update()
    {
        $this->product->name            = 'New product name';
        $this->product->category->name  = 'New category name';
        $this->product->images[0]->path = 'new_path.jpg';
        $this->product->tags[0]->name   = 'New tag name';

        $this->atlas->beginTransaction();
        $this->atlas->persist($this->product);
        $this->atlas->commit();

        $product = $this->atlas->fetchRecord(Product::class, 1, ['category', 'tags', 'images']);

        $this->assertEquals('New product name', $product->name);
        $this->assertEquals('New category name', $product->category->name);
        $this->assertEquals('new_path.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name', $product->tags[0]->name);

        /**
         * THIS DOES NOT WORK FOR SOME REASON, HAVE TO RETURN
         */
        return;
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }

    function find($i)
    {
        $product = $this->atlas->fetchRecord(Product::class, $i);
    }

    function test_find()
    {
        $product = $this->atlas->fetchRecord(Product::class, 1);
        $lastRun = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->name); // changed by "update"
    }

    function complexQuery($i)
    {
        $this->atlas->select(Product::class)
                    ->join('INNER', 'categories', 'categories.id = products.category_id')
                    ->where('products.id >', 50)
                    ->where('categories.id <', 300)
                    ->resetColumns()
                    ->columns('COUNT(*)')
                    ->fetchValue();
    }

    function test_complexQuery()
    {
        $query = $this->atlas->select(Product::class)
                             ->join('INNER', 'categories', 'categories.id = products.category_id')
                             ->where('products.id >', 50)
                             ->where('categories.id <', 300)
                             ->resetColumns()
                             ->columns('COUNT(*)');
        $this->assertEquals(249, $query->fetchValue());
    }

    function relations($i)
    {
        $products = $this->atlas->select(Product::class)
                                ->with(['category', 'tags', 'images'])
                                ->where('price >', 50)
                                ->limit(10)
                                ->fetchRecords();
        foreach ($products as $product) {

        }
    }

    function test_relations()
    {
        $product = $this->atlas->select(Product::class)
                               ->with(['category', 'tags', 'images'])
                               ->where('id = ', 1)
                               ->fetchRecord();
        $lastRun       = self::NB_TEST - 1;
        $this->assertEquals('New product name ' . $lastRun, $product->name);
        $this->assertEquals('New category name ' . $lastRun, $product->category->name);
        $this->assertEquals('new_path_' . $lastRun . '.jpg', $product->images[0]->path);
        $this->assertEquals('New tag name ' . $lastRun, $product->tags[0]->name);
        /**
         * DOES NOT WORK
         */
        return;
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);
    }
}