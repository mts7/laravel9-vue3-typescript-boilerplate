<?php

declare(strict_types=1);

namespace Tests\App\Console\Commands;

use App\Console\Commands\FindMessAnsi;
use Mockery;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * Tests for Mess Detector command
 * @group command
 * @group quality
 */
class FindMessAnsiTest extends TestCase
{
	/**
	 * @throws \InvalidArgumentException
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class)->makePartial();
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput')->andReturn('output');
	}

	/**
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 * @throws \Illuminate\Contracts\Container\CircularDependencyException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 */
	final public function testHandle(): void
	{
		$command = $this->app->make(FindMessAnsi::class);

		ob_start();
		$result = $command->handle();
		ob_end_clean();

		$this->assertEquals(1, $result, 'The mock is incorrect.');
	}
}
