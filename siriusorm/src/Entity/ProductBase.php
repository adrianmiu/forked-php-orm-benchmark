<?php

declare(strict_types=1);

namespace app\Entity;

use Sirius\Orm\Collection\Collection;
use Sirius\Orm\Entity\ClassMethodsEntity;

abstract class ProductBase extends ClassMethodsEntity
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

    protected function castCategoryIdAttribute($value)
    {
        return $value === null ? $value : intval($value);
    }

    public function setCategoryId(?int $value)
    {
        $this->set('category_id', $value);
    }

    public function getCategoryId(): ?int
    {
        return $this->get('category_id');
    }

    public function setName(string $value)
    {
        $this->set('name', $value);
    }

    public function getName(): string
    {
        return $this->get('name');
    }

    public function setSku(string $value)
    {
        $this->set('sku', $value);
    }

    public function getSku(): string
    {
        return $this->get('sku');
    }

    protected function castPriceAttribute($value)
    {
        return $value === null ? $value : round((float)$value, 2);
    }

    public function setPrice(float $value)
    {
        $this->set('price', $value);
    }

    public function getPrice(): float
    {
        return $this->get('price');
    }

    public function setImages(Collection $value)
    {
        $this->set('images', $value);
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->get('images');
    }

    public function addImage(Image $image)
    {
        $this->get('images')->add($image);
    }

    public function setTags(Collection $value)
    {
        $this->set('tags', $value);
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->get('tags');
    }

    public function addTag(Tag $tag)
    {
        $this->get('tags')->add($tag);
    }

    protected function castCategoryAttribute($value)
    {
        if ($value === null) {
            return $value;
        }

        return $value instanceOf Category ? $value : new Category((array) $value);
    }

    public function setCategory(?Category $value)
    {
        $this->set('category', $value);
    }

    public function getCategory(): ?Category
    {
        return $this->get('category');
    }
}
