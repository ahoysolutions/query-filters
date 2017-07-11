<?php

namespace AhoySolutions\QueryFilters;

use Illuminate\Support\ServiceProvider;

class QueryFiltersServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/config/queryfilters.php' => config_path('queryfilters.php'),
		]);

		$this->mergeConfigFrom(__DIR__ . '/config/queryfilters.php', 'queryfilters');

		if ($this->app->runningInConsole()) {
			$this->commands(QueryFiltersMakeCommand::class);
		}
	}
}