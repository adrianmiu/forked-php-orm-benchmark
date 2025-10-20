<?php

#[\Doctrine\ORM\Mapping\Entity]
#[\Doctrine\ORM\Mapping\Table(name: 'product')]
class Product extends BaseModel
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'AUTO')]
    #[\Doctrine\ORM\Mapping\Column(type: 'integer')]
    public $id;
    #[\Doctrine\ORM\Mapping\Column]
    public $name;
    #[\Doctrine\ORM\Mapping\Column(length: 24)]
    public $sku;
    #[\Doctrine\ORM\Mapping\Column(type: 'float')]
    public $price;
    #[\Doctrine\ORM\Mapping\Column(type: 'integer', nullable: true)]
    public $category_id;
    #[\Doctrine\ORM\Mapping\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[\Doctrine\ORM\Mapping\ManyToOne(targetEntity: Category::class, cascade: ["persist"])]
    public $category;
    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: Tag::class,cascade: ["persist"])]
    #[\Doctrine\ORM\Mapping\JoinTable(name: "products_tags")]
    public $tags;
    #[\Doctrine\ORM\Mapping\OneToMany(targetEntity: ProductImage::class, mappedBy: "product", cascade: ["persist"])]
    #[\Doctrine\ORM\Mapping\JoinColum(name: "id", referencedColumnName: "imageable_id", nullable: true)]
    public $images;
}