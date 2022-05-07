<?php

declare(strict_types=1);

namespace Tests\App\Services;

use App\Services\MessDetector;
use Tests\Assert;
use InvalidArgumentException;
use Mockery;
use Symfony\Component\Process\Process;
use Tests\TestCase;

/**
 * Test for MessDetector
 * @group quality
 */
class MessDetectorTest extends TestCase
{
	use Assert;

	private MessDetector $messDetector;

	public function setUp(): void
	{
		parent::setUp();

		$process = Mockery::mock('overload:' . Process::class)->makePartial();
		$process->shouldReceive('run')->andReturn(1);
		$process->shouldReceive('getOutput')->andReturn('output');

		$this->messDetector = $this->app->make(MessDetector::class);
	}

	final public function testCreateReportFileWithNullName(): void
	{
		$this->assertCreateReportFile(
			null,
			MessDetector::REPORT_DIRECTORY . '/' . MessDetector::DEFAULT_FILE_NAME . '.html'
		);
	}

	final public function testCreateReportFileWithNamePart(): void
	{
		$this->assertCreateReportFile('name', MessDetector::REPORT_DIRECTORY . '/name.html');
	}

	final public function testCreateReportFileWithFullName(): void
	{
		$this->assertCreateReportFile('name.ext', MessDetector::REPORT_DIRECTORY . '/name.ext');
	}

	final public function testCreateReportFileWithInvalidRenderer(): void
	{
		$renderer = 'ansi';
		$this->messDetector->setRenderer($renderer);

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} cannot be saved as a file.");

		$this->messDetector->createReportFile('name');
	}

	final public function testDisplayReport(): void
	{
		ob_start();
		$value = $this->messDetector->displayReport();
		ob_end_clean();
		$this->assertEquals(1, $value, 'Mock was not set up properly.');
	}

	final public function testSetRendererSuccess(): void
	{
		$this->assertNoException(function () {
			$this->messDetector->setRenderer('text');
		});
	}

	final public function testSetRendererFail(): void
	{
		$renderer = 'invalid';

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} is not a valid PHPMD renderer.");

		$this->messDetector->setRenderer($renderer);
	}

	/**
	 * Creates a report file, then deletes the report file.
	 */
	private function assertCreateReportFile(?string $file, string $filePath): void
	{
		$result = $this->messDetector->createReportFile($file);
		$fileExists = is_file($filePath);
		$this->messDetector->deleteReport($file);

		$this->assertEquals(1, $result);
		$this->assertTrue($fileExists);
		$this->assertFileDoesNotExist($filePath);
	}
}
