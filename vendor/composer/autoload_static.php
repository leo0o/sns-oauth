<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit472b6bea1a5679a233d46872a9d52ddb
{
    public static $prefixLengthsPsr4 = array (
        'o' => 
        array (
            'oauth\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'oauth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit472b6bea1a5679a233d46872a9d52ddb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit472b6bea1a5679a233d46872a9d52ddb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
