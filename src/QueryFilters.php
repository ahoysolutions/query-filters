<?php

namespace AhoySolutions\QueryFilters;

use Illuminate\Http\Request;

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
	 * Registered filters to operate upon.
	 *
	 * @var array
	 */
	protected $filters = [];

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

		foreach ($this->getFilters() as $filter => $value) {
			if (method_exists($this, $filter)) {
				if (is_iterable($value)) {
					foreach ($value as $item) {
						$this->$filter($item);
					}
				}
				else {
					$this->$filter($value);
				}
			}
		}

		return $this->builder;
	}

	/**
	 * Fetch all relevant filters from the request.
	 *
	 * @return array
	 */
	protected function getFilters()
	{
		return array_intersect_key($this->request->all(), array_flip($this->filters));
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
}