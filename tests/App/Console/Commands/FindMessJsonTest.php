<?php

declare(strict_types=1);

namespace Tests;

use App\Console\Commands\FindMessJson;
use App\Services\MessDetector;
use Mockery;
use Symfony\Component\Process\Process;

/**
 * Tests for Mess Detector command
 * @group command
 * @group quality
 */
class FindMessJsonTest extends TestCase
{
	public function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class);
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput');
	}

	final public function testHandle(): void
	{
		$command = $this->app->make(FindMessJson::class);
		$result = $command->handle();
		$filePath = MessDetector::REPORT_DIRECTORY . MessDetector::DEFAULT_FILE_NAME . '.json';
		$fileExists = is_file($filePath);
		unlink($filePath);

		$this->assertEquals(1, $result);
		$this->assertTrue($fileExists);
		$this->assertFileDoesNotExist($filePath);
	}
}
