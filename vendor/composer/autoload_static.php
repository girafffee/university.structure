<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit614d53a617be37aa1e9399b9229e3468
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit614d53a617be37aa1e9399b9229e3468::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit614d53a617be37aa1e9399b9229e3468::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit614d53a617be37aa1e9399b9229e3468::$classMap;

        }, null, ClassLoader::class);
    }
}