<?php namespace App\Phphub\Markdown;

use Illuminate\Support\ServiceProvider;
use Event;
use App;

class MarkdownServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton('App\Phphub\Markdown\Markdown', function ($app) {
            return new \App\Phphub\Markdown\Markdown;
        });
    }

    public function provides()
    {
        return ['App\Phphub\Markdown\Markdown'];
    }
}
