<?php

namespace Albertgrala\Notes;

use Illuminate\Support\ServiceProvider;

class NotesServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->package('albertgrala/notes');
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app['notes.add'] = $this->app->share(function($app)
    {
      return new Commands\NotesAddCommand($app);
    });

    $this->app['notes.show'] = $this->app->share(function($app)
    {
      return new Commands\NotesShowCommand($app);
    });

    $this->app['notes.complete'] = $this->app->share(function($app)
    {
      return new Commands\NotesCompleteCommand($app);
    });

    $this->app['notes.delete'] = $this->app->share(function($app)
    {
      return new Commands\NotesDeleteCommand($app);
    });


    $this->commands(
      'notes.add',
      'notes.show',
      'notes.complete',
      'notes.delete'
    );
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array();
  }

}