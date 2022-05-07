<?php

declare(strict_types=1);

namespace Tests\App\Services;

use App\Services\PsalmRunner;
use Mockery;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * Tests for PsalmRunner
 *
 * @group quality
 */
class PsalmRunnerTest extends TestCase
{
	private PsalmRunner $runner;
	/**
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testDisplayReport(): void
	{
		ob_start();
		$value = $this->runner->displayReport();
		ob_end_clean();
		$this->assertEquals(1, $value, 'Mock was not set up properly.');
	}
	/**
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 * @throws \Illuminate\Contracts\Container\CircularDependencyException
	 * @throws \InvalidArgumentException
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class)->makePartial();
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput')->andReturn('output');

		/** @var PsalmRunner runner */
		$this->runner = $this->app->make(PsalmRunner::class);
	}
}
