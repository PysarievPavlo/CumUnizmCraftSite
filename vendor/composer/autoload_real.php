<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInita1dc8ec52a75ffd329c26b8eab906627
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInita1dc8ec52a75ffd329c26b8eab906627', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInita1dc8ec52a75ffd329c26b8eab906627', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInita1dc8ec52a75ffd329c26b8eab906627::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
