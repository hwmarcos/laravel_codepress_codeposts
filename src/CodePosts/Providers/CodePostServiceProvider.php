<?php

namespace CodePress\CodePosts\Providers;

use CodePress\CodePosts\Repository\PostRepositoryEloquent;
use CodePress\CodePosts\Repository\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Ktquez\Tinymce\TinymceServiceProvider;

class CodePostServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([__DIR__ . '/../../resources/migrations/' => base_path('database/migrations')], 'migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/codepost/', 'codepost');
        require(__DIR__ . '/../../routes.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepositoryEloquent::class);
        $this->app->register(TinymceServiceProvider::class);
    }
}