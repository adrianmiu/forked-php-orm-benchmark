<?php

require_once __DIR__ . '/../AbstractTestSuite.php';

class DoctrineMTestSuite extends AbstractTestSuite
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = null;
    private static $classes = null;

    public function initialize()
    {
        require_once "vendor/autoload.php";

        $cache  = new \Doctrine\Common\Cache\ArrayCache;
        $config = new Doctrine\ORM\Configuration;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/models');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(__DIR__ . '/proxies');
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses(true); // no code generation in production

        $dbParams = array('driver' => 'pdo_sqlite', 'memory' => true);
//      unlink(__DIR__ . '/sqlite');
//      $dbParams = array('driver' => 'pdo_sqlite', 'path' => __DIR__ . '/sqlite');

        $this->em = Doctrine\ORM\EntityManager::create($dbParams, $config);

        if ( ! self::$classes) {
            self::$classes = $this->em->getMetadataFactory()->getAllMetadata();
        }

        $schemaTool = new Doctrine\ORM\Tools\SchemaTool($this->em);
        $schemaTool->createSchema(self::$classes);

    }

    public function beginTransaction()
    {
        $this->em->beginTransaction();
    }

    private $clears = 0;

    public function clearCache()
    {
        if ($this->clears > 1) {
            $this->em->clear(); // clear the first level cache (identity map), as in other examples
            // so that objects are not re-used
        }
        $this->clears++;
    }

    public function commit()
    {
        $this->em->flush();
        $this->em->commit();
    }


    function insert($i)
    {
        $category = new Category([
            'name' => 'Category #c' . $i
        ]);

        $product = new Product([
            'name'  => 'Product #' . $i,
            'sku'   => 'SKU #' . $i,
            'price' => sqrt(1000 + $i * 100),
        ]);

        $product->category = $category;

        $product->images = [
            new ProductImage([
                'path' => 'image_' . $i . '.jpg'
            ])
        ];

        $product->tags = [
            new Tag(['name' => 'Tag #t1_' . $i]),
            new Tag(['name' => 'Tag #t2_' . $i])
        ];

        $this->em->beginTransaction();
        $this->em->persist($product);
        $this->em->flush();
        $this->em->commit();

        $this->em->detach($product);
        $this->em->clear();
        $this->products[] = $product->id;

        return $product;
    }

    public function test_insert()
    {
        $product = $this->insert(0);
        $this->em->flush();
        $product = $this->em->find(Product::class, $product->id);
        $this->assertNotNull($product, 'Product not found');
        $this->assertNotNull($product->category_id, 'Category was not associated with the product');
        $this->assertNotNull($product->tags[0]->name, 'Tag not present');

        /**
         * DOES NOT WORK
         */
        //$this->assertNotNull($product->images[0]->path, 'Image not present');
        $this->em->clear();
    }

    function prepare_update()
    {
        $this->insert(0);
        $this->product = $this->em->find(Product::class, 1);
    }

    function update($i)
    {
        $this->product->name           = 'New product name ' . $i;
        $this->product->category->name = 'New category name ' . $i;
        #$this->product->images[0]->path = 'new_path_' . $i . '.jpg'; // does not work
        $this->product->tags[0]->name = 'New tag name ' . $i;

        $this->em->persist($this->product);
        $this->em->flush();
    }

    function test_update()
    {
        $this->product->name           = 'New product name';
        $this->product->category->name = 'New category name';
        #$this->product->images[0]->path = 'new_path.jpg'; // does not work
        $this->product->tags[0]->name = 'New tag name';

        $this->em->persist($this->product);
        $this->em->flush();

        $product = $this->em->find(Product::class, 1);

        $this->assertEquals('New product name', $product->name);
        $this->assertEquals('New category name', $product->category->name);
        $this->assertEquals('New tag name', $product->tags[0]->name);
        $this->assertEquals('Tag #t2_0', $product->tags[1]->name);

        /**
         * DOES NOT WORK
         */
        //$this->assertEquals('new_path.jpg', $product->images[0]->path);
    }

    function find($i)
    {
        $product = $this->em->find(Product::class, $i);
        if ($product) {
            $this->em->detach($product);
        }
    }

    function test_find()
    {
        $this->em->clear();
        $product = $this->em->find(Product::class, 1);
        $this->assertEquals('New product name ' . (self::NB_TEST - 1), $product->name); // changed by "update"
        $this->em->clear();
    }

    function complexQuery($i)
    {
        $this->em
            ->createQueryBuilder()
            ->from('Product', 'p')
            ->join('p.category', 'c')
            ->select('count(p)')
            ->where('p.id > 50')
            ->andWhere('c.id < 300')
            ->getQuery()
            ->getSingleScalarResult();
    }

    function test_complexQuery()
    {
        $query  = $this->em
            ->createQueryBuilder()
            ->from('Product', 'p')
            ->join('p.category', 'c')
            ->select('count(p)')
            ->where('p.id > 50')
            ->andWhere('c.id < 300')
            ->getQuery();
        $result = $query->getSingleScalarResult();
        $this->assertEquals(249, $result);
        $this->em->clear();
    }

    function relations($i)
    {
        $products = $this->em->createQuery('SELECT p FROM Product p where p.price > 50')
                             ->setFirstResult($i)
                             ->setMaxResults(10)
                             ->getResult();
        foreach ($products as $product) {

        }
        $this->em->clear();
    }

    function test_relations()
    {
        $products = $this->em->createQuery('SELECT p FROM Product p where p.price > 50')
                             ->setFirstResult(0)
                             ->setMaxResults(1)
                             ->getResult();
        $product  = $products[0];
        $lastRun  = self::NB_TEST - 1;
        $this->assertNotNull($product->name);
        $this->assertNotNull($product->category->name);
        $this->em->clear();
    }
}