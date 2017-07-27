<?php

namespace AhoySolutions\QueryFilters;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Debug\Exception\FatalThrowableError;

abstract class QueryFilters
{
	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * The Eloquent builder.
	 *
	 * @var \Illuminate\Database\Eloquent\Builder
	 */
	protected $builder;

	/**
	 * A list of default filters to call after processing the query filters.
	 *
	 * @var array
	 */
	protected $defaultFilters = [];

	/**
	 * QueryFilters constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * Apply the filters.
	 *
	 * @param  Builder $builder
	 * @return Builder
	 */
	public function apply($builder)
	{
		$this->builder = $builder;

		foreach ($this->request->all() as $filter => $value) {
			$method = 'filter' . Str::studly($filter);

			if (method_exists($this, $method)) {
				if (is_iterable($value)) {
					foreach ($value as $item) {
						$this->$method($item);
					}
				} else {
					$this->$method($value);
				}
			}
			else {
				$this->missingFilter($filter, $value);
			}
		}

		foreach ($this->defaultFilters as $filter)
		{
			if (method_exists($this, $filter)) {
				$this->$filter();
			}
			else {
				$this->missingFilter($filter, $value);
			}
		}
	}

	/**
	 * Reset any previously set orderBy() on the builder object.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	protected function resetOrderBy()
	{
		$this->builder->getQuery()->orders = [];

		return $this->builder;
	}

	/**
	 * Removes a filter from the default filter list.
	 *
	 * @param $filter
	 */
	protected function removeDefaultFilter($filter)
	{
		$this->defaultFilters = array_diff($this->defaultFilters, (array) $filter);
	}

	/**
	 * Called when a filter does not exist, but is being referenced in the query scope.
	 * For logging, throwing an exception, etc.
	 *
	 * @param $filter
	 * @param $value
	 */
	protected function missingFilter($filter, $value)
	{
		//
	}
}