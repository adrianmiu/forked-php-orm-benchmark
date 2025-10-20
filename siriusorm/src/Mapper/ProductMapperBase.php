<?php

declare(strict_types=1);

namespace app\Mapper;

use Sirius\Orm\Action\Delete as DeleteAction;
use Sirius\Orm\Action\Insert as InsertAction;
use Sirius\Orm\Action\Update as UpdateAction;
use Sirius\Orm\Connection;
use Sirius\Orm\Entity\ClassMethodsHydrator;
use Sirius\Orm\Entity\StateEnum;
use Sirius\Orm\Exception\FailedActionException;
use Sirius\Orm\Mapper;
use Sirius\Orm\MapperConfig;
use Sirius\Sql\Bindings;
use app\Entity\Product;

/**
 * @method ProductQuery where($column, $value, $condition)
 * @method ProductQuery orderBy(string $expr, string ...$exprs)
 */
abstract class ProductMapperBase extends Mapper
{
    protected function init()
    {
        $this->mapperConfig = MapperConfig::fromArray([
            'entityClass' => 'app\Entity\Product',
            'primaryKey' => 'id',
            'table' => 'products',
            'tableAlias' => null,
            'guards' => [],
            'columns' => ['id', 'category_id', 'name', 'sku', 'price'],
            'columnAttributeMap' => [],
            'casts' => ['id' => 'int', 'category_id' => 'int', 'name' => 'string', 'sku' => 'string', 'price' => 'decimal:2'],
        ]);
        $this->hydrator     = new ClassMethodsHydrator($this->orm->getCastingManager());
        $this->hydrator->setMapper($this);

        $this->initRelations();
    }

    protected function initRelations()
    {
        $this->addRelation('images', [
            'type' => 'one_to_many',
            'native_key' => 'id',
            'foreign_mapper' => 'images',
            'foreign_key' => 'imageable_id',
            'foreign_guards' => ['imageable_type' => 'products'],
            'load_strategy' => 'lazy',
        ]);

        $this->addRelation('tags', [
            'type' => 'many_to_many',
            'native_key' => 'id',
            'foreign_mapper' => 'tags',
            'foreign_key' => 'id',
            'load_strategy' => 'lazy',
            'pivot_table' => 'products_tags',
            'pivot_native_column' => 'product_id',
            'pivot_foreign_column' => 'tag_id',
        ]);

        $this->addRelation('category', [
            'type' => 'many_to_one',
            'native_key' => 'category_id',
            'foreign_mapper' => 'categories',
            'foreign_key' => 'id',
            'load_strategy' => 'lazy',
        ]);
    }

    public function find($pk, array $load = []): ?Product
    {
        return $this->newQuery()->find($pk, $load);
    }

    public function newQuery(): ProductQuery
    {
        $query = new ProductQuery($this->getReadConnection(), $this);
        return $this->behaviours->apply($this, __FUNCTION__, $query);
    }

    public function newSubselectQuery(Connection $connection, Bindings $bindings, string $indent): ProductQuery
    {
        $query = new ProductQuery($this->getReadConnection(), $this, $bindings, $indent);
        return $this->behaviours->apply($this, __FUNCTION__, $query);
    }

    public function save(Product $entity, $withRelations = false): bool
    {
        $entity = $this->behaviours->apply($this, 'saving', $entity);
        $action = $this->newSaveAction($entity, ['relations' => $withRelations]);
        $result = $this->runActionInTransaction($action);
        $entity = $this->behaviours->apply($this, 'saved', $entity);

        return $result;
    }

    public function newSaveAction(Product $entity, $options): UpdateAction
    {
        if ( ! $this->getHydrator()->getPk($entity) || $entity->getState() == StateEnum::NEW) {
            $action = new InsertAction($this, $entity, $options);
        } else {
            $action = new UpdateAction($this, $entity, $options);
        }

        return $this->behaviours->apply($this, __FUNCTION__, $action);
    }

    public function delete(Product $entity, $withRelations = false): bool
    {
        $entity = $this->behaviours->apply($this, 'deleting', $entity);
        $action = $this->newDeleteAction($entity, ['relations' => $withRelations]);
        $result = $this->runActionInTransaction($action);
        $entity = $this->behaviours->apply($this, 'deleted', $entity);

        return $result;
    }

    public function newDeleteAction(Product $entity, $options): DeleteAction
    {
        $action = new DeleteAction($this, $entity, $options);

        return $this->behaviours->apply($this, __FUNCTION__, $action);
    }
}
