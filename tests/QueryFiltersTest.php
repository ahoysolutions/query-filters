<?php

namespace AhoySolutions\QueryFilters\Tests;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;

class QueryFiltersTest extends TestCase
{
	use MockeryPHPUnitIntegration;

	/** @var  MockInterface */
	protected $request;

	/** @var  MockInterface */
	protected $builder;

	public function setUp()
	{
		parent::setUp();

		$this->request = \Mockery::mock(Request::class);
		$this->builder = \Mockery::mock(Builder::class);
	}

	/** @test */
	public function it_calls_query_filtering_methods_and_default_fitlers()
	{
		$this->request->shouldReceive(['all' => [
			'no-value' => null,
			'single-value' => 'value-to-return',
			'multi-value' => [
				'first-value',
				'second-value',
				'third-value',
			],
			'does-not-exist-as-filter' => null,
		]]);

		$this->builder->shouldReceive('filterNoValue')->once();
		$this->builder->shouldReceive('filterSingleValue')->with('value-to-return')->once();
		$this->builder->shouldReceive('filterMultiValue')->times(3);
		$this->builder->shouldReceive('defaultFilterCalled')->once();
		$this->builder->shouldReceive('missingFilter')->with('does-not-exist-as-filter', null)->once();

		$this->builder->shouldNotReceive('filterDoesNotExistAsFilter');

		$dummyFilters = new DummyFilters($this->request);
		$dummyFilters->apply($this->builder);
	}

	/** @test */
	public function it_can_remove_default_filter_calls()
	{
		$this->request->shouldReceive(['all' => [
			'remove-default-filter' => null,
		]]);

		$this->builder->shouldReceive('defaultFilterRemoved')->once();
		$this->builder->shouldNotReceive('defaultFilterCalled');

		$dummyFilters = new DummyFilters($this->request);
		$dummyFilters->apply($this->builder);
	}
}