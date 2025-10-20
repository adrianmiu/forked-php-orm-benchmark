<?php

declare(strict_types=1);

namespace app\Entity;

use Sirius\Orm\Entity\ClassMethodsEntity;

abstract class CategoryBase extends ClassMethodsEntity
{
    public function __construct(array $attributes = [], ?string $state = null)
    {
        parent::__construct($attributes, $state);
    }

    protected function castIdAttribute($value)
    {
        return $value === null ? $value : intval($value);
    }

    public function setId(?int $value)
    {
        $this->set('id', $value);
    }

    public function getId(): ?int
    {
        return $this->get('id');
    }

    public function setName(string $value)
    {
        $this->set('name', $value);
    }

    public function getName(): string
    {
        return $this->get('name');
    }
}
