<?php

declare(strict_types=1);

namespace Tests\App\Console\Commands;

use App\Console\Commands\FindMessJson;
use App\Services\MessDetector;
use Mockery;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * Tests for Mess Detector command
 * @group command
 * @group quality
 */
class FindMessJsonTest extends TestCase
{
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

	/**
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 * @throws \Illuminate\Contracts\Container\CircularDependencyException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 */
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
