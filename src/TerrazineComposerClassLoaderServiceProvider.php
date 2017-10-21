<?php

namespace Terrazine\ComposerClassLoader;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class TerrazineComposerClassLoaderServiceProvider
 * @package Terrazine\ComposerClassLoader
 */
class TerrazineComposerClassLoaderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(ClassLoader::class, $this->getClassLoaderInstance());
    }

    /**
     * Returns the active composer class loader instance.
     *
     * @return ClassLoader
     * @internal
     */
    public function getClassLoaderInstance(): ClassLoader {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->getHashedComposerClass()::getLoader();
    }

    /**
     * Returns autoload_real.php ::class string.
     *
     * @return string
     * @internal
     */
    public function getHashedComposerClass(): string {
        return preg_match_all("/return (ComposerAutoloaderInit.*)::/", $this->getAutoloadFile()->getContents(), $matches) ? $matches[1][0] : null;
    }

    /**
     * Returns the primary composer file.
     *
     * @return SplFileInfo
     * @internal
     */
    public function getAutoloadFile(): SplFileInfo {
        return new SplFileInfo(base_path('vendor/autoload.php'), 'vendor', 'vendor/autoload.php');
    }
}
