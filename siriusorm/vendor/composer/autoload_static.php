<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7858494e55ab359738351aa495615623
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Inflector\\' => 28,
            'Sirius\\Sql\\' => 11,
            'Sirius\\Orm\\' => 11,
        ),
        'P' => 
        array (
            'Psr\\EventDispatcher\\' => 20,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Collections\\' => 28,
        ),
        'A' => 
        array (
            'Atlas\\Pdo\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/inflector',
        ),
        'Sirius\\Sql\\' => 
        array (
            0 => __DIR__ . '/..' . '/siriusphp/sql/src',
        ),
        'Sirius\\Orm\\' => 
        array (
            0 => __DIR__ . '/..' . '/siriusphp/orm/src',
        ),
        'Psr\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/event-dispatcher/src',
        ),
        'Doctrine\\Common\\Collections\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/collections/lib/Doctrine/Common/Collections',
        ),
        'Atlas\\Pdo\\' => 
        array (
            0 => __DIR__ . '/..' . '/atlas/pdo/src',
        ),
    );

    public static $classMap = array (
        'Nette\\ArgumentOutOfRangeException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\DeprecatedException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\DirectoryNotFoundException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\FileNotFoundException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\HtmlStringable' => __DIR__ . '/..' . '/nette/utils/src/Utils/HtmlStringable.php',
        'Nette\\IOException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\InvalidArgumentException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\InvalidStateException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Iterators\\CachingIterator' => __DIR__ . '/..' . '/nette/utils/src/Iterators/CachingIterator.php',
        'Nette\\Iterators\\Mapper' => __DIR__ . '/..' . '/nette/utils/src/Iterators/Mapper.php',
        'Nette\\Localization\\ITranslator' => __DIR__ . '/..' . '/nette/utils/src/compatibility.php',
        'Nette\\Localization\\Translator' => __DIR__ . '/..' . '/nette/utils/src/Utils/Translator.php',
        'Nette\\MemberAccessException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\NotImplementedException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\NotSupportedException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\OutOfRangeException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\PhpGenerator\\Attribute' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Attribute.php',
        'Nette\\PhpGenerator\\ClassType' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/ClassType.php',
        'Nette\\PhpGenerator\\Closure' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Closure.php',
        'Nette\\PhpGenerator\\Constant' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Constant.php',
        'Nette\\PhpGenerator\\Dumper' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Dumper.php',
        'Nette\\PhpGenerator\\Factory' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Factory.php',
        'Nette\\PhpGenerator\\GlobalFunction' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/GlobalFunction.php',
        'Nette\\PhpGenerator\\Helpers' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Helpers.php',
        'Nette\\PhpGenerator\\Literal' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Literal.php',
        'Nette\\PhpGenerator\\Method' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Method.php',
        'Nette\\PhpGenerator\\Parameter' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Parameter.php',
        'Nette\\PhpGenerator\\PhpFile' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/PhpFile.php',
        'Nette\\PhpGenerator\\PhpLiteral' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/PhpLiteral.php',
        'Nette\\PhpGenerator\\PhpNamespace' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/PhpNamespace.php',
        'Nette\\PhpGenerator\\Printer' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Printer.php',
        'Nette\\PhpGenerator\\PromotedParameter' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/PromotedParameter.php',
        'Nette\\PhpGenerator\\Property' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Property.php',
        'Nette\\PhpGenerator\\PsrPrinter' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/PsrPrinter.php',
        'Nette\\PhpGenerator\\Traits\\AttributeAware' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Traits/AttributeAware.php',
        'Nette\\PhpGenerator\\Traits\\CommentAware' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Traits/CommentAware.php',
        'Nette\\PhpGenerator\\Traits\\FunctionLike' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Traits/FunctionLike.php',
        'Nette\\PhpGenerator\\Traits\\NameAware' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Traits/NameAware.php',
        'Nette\\PhpGenerator\\Traits\\VisibilityAware' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Traits/VisibilityAware.php',
        'Nette\\PhpGenerator\\Type' => __DIR__ . '/..' . '/nette/php-generator/src/PhpGenerator/Type.php',
        'Nette\\SmartObject' => __DIR__ . '/..' . '/nette/utils/src/Utils/SmartObject.php',
        'Nette\\StaticClass' => __DIR__ . '/..' . '/nette/utils/src/Utils/StaticClass.php',
        'Nette\\UnexpectedValueException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\ArrayHash' => __DIR__ . '/..' . '/nette/utils/src/Utils/ArrayHash.php',
        'Nette\\Utils\\ArrayList' => __DIR__ . '/..' . '/nette/utils/src/Utils/ArrayList.php',
        'Nette\\Utils\\Arrays' => __DIR__ . '/..' . '/nette/utils/src/Utils/Arrays.php',
        'Nette\\Utils\\AssertionException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Callback' => __DIR__ . '/..' . '/nette/utils/src/Utils/Callback.php',
        'Nette\\Utils\\DateTime' => __DIR__ . '/..' . '/nette/utils/src/Utils/DateTime.php',
        'Nette\\Utils\\FileSystem' => __DIR__ . '/..' . '/nette/utils/src/Utils/FileSystem.php',
        'Nette\\Utils\\Floats' => __DIR__ . '/..' . '/nette/utils/src/Utils/Floats.php',
        'Nette\\Utils\\Helpers' => __DIR__ . '/..' . '/nette/utils/src/Utils/Helpers.php',
        'Nette\\Utils\\Html' => __DIR__ . '/..' . '/nette/utils/src/Utils/Html.php',
        'Nette\\Utils\\IHtmlString' => __DIR__ . '/..' . '/nette/utils/src/compatibility.php',
        'Nette\\Utils\\Image' => __DIR__ . '/..' . '/nette/utils/src/Utils/Image.php',
        'Nette\\Utils\\ImageException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Json' => __DIR__ . '/..' . '/nette/utils/src/Utils/Json.php',
        'Nette\\Utils\\JsonException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\ObjectHelpers' => __DIR__ . '/..' . '/nette/utils/src/Utils/ObjectHelpers.php',
        'Nette\\Utils\\ObjectMixin' => __DIR__ . '/..' . '/nette/utils/src/Utils/ObjectMixin.php',
        'Nette\\Utils\\Paginator' => __DIR__ . '/..' . '/nette/utils/src/Utils/Paginator.php',
        'Nette\\Utils\\Random' => __DIR__ . '/..' . '/nette/utils/src/Utils/Random.php',
        'Nette\\Utils\\Reflection' => __DIR__ . '/..' . '/nette/utils/src/Utils/Reflection.php',
        'Nette\\Utils\\RegexpException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Strings' => __DIR__ . '/..' . '/nette/utils/src/Utils/Strings.php',
        'Nette\\Utils\\UnknownImageFileException' => __DIR__ . '/..' . '/nette/utils/src/Utils/exceptions.php',
        'Nette\\Utils\\Validators' => __DIR__ . '/..' . '/nette/utils/src/Utils/Validators.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7858494e55ab359738351aa495615623::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7858494e55ab359738351aa495615623::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7858494e55ab359738351aa495615623::$classMap;

        }, null, ClassLoader::class);
    }
}
