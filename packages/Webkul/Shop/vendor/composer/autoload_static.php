<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit15b8f08ef45738f803007e78b5187fba
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Webkul\\Shop\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Webkul\\Shop\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit15b8f08ef45738f803007e78b5187fba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit15b8f08ef45738f803007e78b5187fba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit15b8f08ef45738f803007e78b5187fba::$classMap;

        }, null, ClassLoader::class);
    }
}