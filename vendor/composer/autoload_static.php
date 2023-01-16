<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbd28332af46f63c200ac4661d2f46844
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Composer\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Composer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbd28332af46f63c200ac4661d2f46844::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbd28332af46f63c200ac4661d2f46844::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbd28332af46f63c200ac4661d2f46844::$classMap;

        }, null, ClassLoader::class);
    }
}