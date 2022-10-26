<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit2a0ce8b2f90e62a845b7d7cdfce6524c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit2a0ce8b2f90e62a845b7d7cdfce6524c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit2a0ce8b2f90e62a845b7d7cdfce6524c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit2a0ce8b2f90e62a845b7d7cdfce6524c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
