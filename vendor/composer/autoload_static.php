<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1dc8ec52a75ffd329c26b8eab906627
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Myproject\\Myapp\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Myproject\\Myapp\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInita1dc8ec52a75ffd329c26b8eab906627::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1dc8ec52a75ffd329c26b8eab906627::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita1dc8ec52a75ffd329c26b8eab906627::$classMap;

        }, null, ClassLoader::class);
    }
}
