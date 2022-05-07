<?php

declare(strict_types=1);

namespace Tests\App\Console\Commands;

use App\Console\Commands\PsalmInfo;
use Mockery;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * Tests for Psalm Info command
 *
 * @group command
 * @group quality
 */
class PsalmInfoTest extends TestCase
{
	/**
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 * @throws \Illuminate\Contracts\Container\CircularDependencyException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testHandle(): void
	{
		/** @var PsalmInfo $command */
		$command = $this->app->make(PsalmInfo::class);
		$result = $command->handle();

		$this->assertEquals(1, $result);
	}
	/**
	 * Sets up mock.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class);
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput');
	}
}
