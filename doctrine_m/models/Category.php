<?php

#[\Doctrine\ORM\Mapping\Entity]
#[\Doctrine\ORM\Mapping\Table(name: 'category')]
class Category extends BaseModel
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'AUTO')]
    #[\Doctrine\ORM\Mapping\Column(type: 'integer')]
    public $id;
    #[\Doctrine\ORM\Mapping\Column(length: 128)]
    public $name;
}