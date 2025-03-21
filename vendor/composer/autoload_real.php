<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit7566f5d7b3b18624e6e38c4508543efb
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

        spl_autoload_register(array('ComposerAutoloaderInit7566f5d7b3b18624e6e38c4508543efb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit7566f5d7b3b18624e6e38c4508543efb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit7566f5d7b3b18624e6e38c4508543efb::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
