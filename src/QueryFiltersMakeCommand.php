<?php

namespace AhoySolutions\QueryFilters;

use Illuminate\Console\GeneratorCommand;

class QueryFiltersMakeCommand extends GeneratorCommand
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:queryfilters';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new query filters class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Query filters';

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/stubs/queryfilters.stub';
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		if ($path = config('queryfilters.path')) {
			return $rootNamespace . '\\' . str_replace('/', '\\', $path);
		}

		return $rootNamespace;
	}
}