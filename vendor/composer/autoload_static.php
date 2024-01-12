<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit56a886da53111b5b1db3cf772bd1585c
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DDOpenstreetmap\\' => 16,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
            'Carbon_Fields_Plugin\\' => 21,
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DDOpenstreetmap\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
        'Carbon_Fields_Plugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/wp-content/plugins/carbon-fields-plugin/core',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit56a886da53111b5b1db3cf772bd1585c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit56a886da53111b5b1db3cf772bd1585c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit56a886da53111b5b1db3cf772bd1585c::$classMap;

        }, null, ClassLoader::class);
    }
}