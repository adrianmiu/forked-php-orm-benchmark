<?php

namespace App\Record;

class Product extends \App\Record\Definition\Product
	{
	protected static array $virtualFields = [
		'tags' => [\PHPFUI\ORM\ManyToMany::class, \App\Table\ProductTag::class, \App\Table\Tag::class, 'position'],
		'images' => [\PHPFUI\ORM\MorphMany::class, \App\Table\Image::class, 'imageable', ],
	];
	}
