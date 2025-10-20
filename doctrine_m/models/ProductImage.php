<?php

#[\Doctrine\ORM\Mapping\Entity]
#[\Doctrine\ORM\Mapping\Table(name: 'product_image')]
class ProductImage extends Image
{
    /** MANY-TO-ONE BIDIRECTIONAL, OWNING SIDE
     * @var Book
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     * @ORM\JoinColumn(name="imageable_id", referencedColumnName="id", nullable=true)
     */
    protected $product;
}