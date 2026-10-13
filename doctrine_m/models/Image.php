<?php

#[\Doctrine\ORM\Mapping\Entity]
#[\Doctrine\ORM\Mapping\Table(name: 'image')]
#[\Doctrine\ORM\Mapping\InheritanceType("SINGLE_TABLE")]
#[\Doctrine\ORM\Mapping\DiscriminatorColumn(name: "imageable_type", type: "string")]
class Image extends BaseModel
{
    #[\Doctrine\ORM\Mapping\Id]
    #[\Doctrine\ORM\Mapping\GeneratedValue(strategy: 'AUTO')]
    #[\Doctrine\ORM\Mapping\Column(type: 'integer')]
    public $id;
    #[\Doctrine\ORM\Mapping\Column(length: 128)]
    public $path;
    #[\Doctrine\ORM\Mapping\Column(type: 'integer', nullable: true)]
    public $imageable_id;
}