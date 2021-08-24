<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7a0b157ccb1804be94a12268b1329fd2
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FSI\\Setup\\Classes\\' => 18,
            'FSI\\General\\Classes\\' => 20,
            'FSI\\Foursquare\\Classes\\' => 23,
            'FSI\\Controller\\Classes\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FSI\\Setup\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/setup',
        ),
        'FSI\\General\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/general',
        ),
        'FSI\\Foursquare\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/foursquare',
        ),
        'FSI\\Controller\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes/controllers',
        ),
    );

    public static $prefixesPsr0 = array (
        'F' => 
        array (
            'FoursquareApi' => 
            array (
                0 => __DIR__ . '/..' . '/hownowstephen/php-foursquare/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7a0b157ccb1804be94a12268b1329fd2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7a0b157ccb1804be94a12268b1329fd2::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7a0b157ccb1804be94a12268b1329fd2::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
