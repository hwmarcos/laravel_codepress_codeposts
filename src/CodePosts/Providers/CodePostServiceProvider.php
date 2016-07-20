<?php
/**
 * Created by PhpStorm.
 * User: helder
 * Date: 03/07/2016
 * Time: 19:27
 */

namespace CodePress\CodePosts\Providers;

use Illuminate\Support\ServiceProvider;

class CodeCategoryServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([__DIR__ . '/../../resources/migrations/' => base_path('database/migrations')], 'migartions');
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
    }
}