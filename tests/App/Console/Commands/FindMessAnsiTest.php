<?php

declare(strict_types=1);

namespace Tests;

use App\Console\Commands\FindMessAnsi;
use Mockery;
use Symfony\Component\Process\Process;

/**
 * Tests for Mess Detector command
 * @group command
 * @group quality
 */
class FindMessAnsiTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class)->makePartial();
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput')->andReturn('output');
	}

	final public function testHandle(): void
	{
		$command = $this->app->make(FindMessAnsi::class);

		ob_start();
		$result = $command->handle();
		ob_end_clean();

		$this->assertEquals(1, $result, 'The mock is incorrect.');
	}
}
