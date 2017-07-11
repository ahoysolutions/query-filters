<?php

namespace AhoySolutions\QueryFilters;

trait FiltersByQuery
{
	/**
	 * Adds a query scope to a model which adds filters and sorts based on the query string.
	 *
	 * @param Illuminate\Database\Eloquent\Builder
	 * @param QueryFilters $filters
	 * @return Illuminate\Database\Eloquent\Builder
	 * @internal param AhoySolutions\QueryFilters\QueryFilters $filters
	 */
	public function scopeFilter($query, QueryFilters $filters)
	{
		return $filters->apply($query);
	}
}