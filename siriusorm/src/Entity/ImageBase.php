<?php

declare(strict_types=1);

namespace app\Entity;

use Sirius\Orm\Entity\ClassMethodsEntity;

abstract class ImageBase extends ClassMethodsEntity
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

    public function setImageableType(string $value)
    {
        $this->set('imageable_type', $value);
    }

    public function getImageableType(): string
    {
        return $this->get('imageable_type');
    }

    protected function castImageableIdAttribute($value)
    {
        return $value === null ? $value : intval($value);
    }

    public function setImageableId(int $value)
    {
        $this->set('imageable_id', $value);
    }

    public function getImageableId(): int
    {
        return $this->get('imageable_id');
    }

    public function setPath(string $value)
    {
        $this->set('path', $value);
    }

    public function getPath(): string
    {
        return $this->get('path');
    }
}
