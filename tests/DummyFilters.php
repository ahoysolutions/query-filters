<?php

namespace AhoySolutions\Tests;

use AhoySolutions\QueryFilters\QueryFilters;

class DummyFilters extends QueryFilters
{
	protected $defaultFilters = [
		'willBeCalledByDefault',
	];

	protected function filterNoValue()
	{
		$this->builder->filterNoValue();
	}

	protected function filterSingleValue($value)
	{
		$this->builder->filterSingleValue($value);
	}

	protected function filterMultiValue($value)
	{
		$this->builder->filterMultiValue($value);
	}

	protected function filterRemoveDefaultFilter()
	{
		$this->removeDefaultFilter('willBeCalledByDefault');

		$this->builder->defaultFilterRemoved();
	}

	protected function willBeCalledByDefault()
	{
		$this->builder->defaultFilterCalled();
	}

	protected function missingFilter($filter, $value)
	{
		$this->builder->missingFilter($filter, $value);
	}
}