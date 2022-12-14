<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a0ce8b2f90e62a845b7d7cdfce6524c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit2a0ce8b2f90e62a845b7d7cdfce6524c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2a0ce8b2f90e62a845b7d7cdfce6524c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2a0ce8b2f90e62a845b7d7cdfce6524c::$classMap;

        }, null, ClassLoader::class);
    }
}
