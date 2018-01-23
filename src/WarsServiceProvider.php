<?php

namespace TestRoman\Wars;

use TestRoman\Wars\Controllers\WarController;
use Illuminate\Support\ServiceProvider;

class WarsServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    require __DIR__.'/routes/web.php';

    $this->loadViewsFrom(__DIR__.'/views', 'Wars');

    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__.'/views' => $this->app->resourcePath('/views'),
      ]);
    }

    $this->publishes([
      __DIR__ . '/migrations/2017_18_23_061251_wars_migration.php' => base_path('database/migrations/2017_10_23_061251_wars_migration.php'),
    ]);
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('Wars', function ($app) {
      return new WarController;
    });
  }
}
