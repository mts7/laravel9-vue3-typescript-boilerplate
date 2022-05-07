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

		$this->messDetector = $this->app->make(MessDetector::class);
	}

	/**
	 * @throws \InvalidArgumentException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testCreateReportFileWithNullName(): void
	{
		$this->assertCreateReportFile(
			null,
			MessDetector::REPORT_DIRECTORY . '/' . MessDetector::DEFAULT_FILE_NAME . '.html'
		);
	}

	/**
	 * @throws \InvalidArgumentException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testCreateReportFileWithNamePart(): void
	{
		$this->assertCreateReportFile('name', MessDetector::REPORT_DIRECTORY . '/name.html');
	}

	/**
	 * @throws \InvalidArgumentException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testCreateReportFileWithFullName(): void
	{
		$this->assertCreateReportFile('name.ext', MessDetector::REPORT_DIRECTORY . '/name.ext');
	}

	/**
	 * @throws \InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function testCreateReportFileWithInvalidRenderer(): void
	{
		$renderer = 'ansi';
		$this->messDetector->setRenderer($renderer);

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} cannot be saved as a file.");

		$this->messDetector->createReportFile('name');
	}

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
		$value = $this->messDetector->displayReport();
		ob_end_clean();
		$this->assertEquals(1, $value, 'Mock was not set up properly.');
	}

	/**
	 * Provides the arrangement and act steps within the callback for the assertion.
	 */
	final public function testSetRendererSuccess(): void
	{
		$this->assertNoException(function () {
			$this->messDetector->setRenderer('text');
		});
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	final public function testSetRendererFail(): void
	{
		$renderer = 'invalid';

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} is not a valid PHPMD renderer.");

		$this->messDetector->setRenderer($renderer);
	}

	/**
	 * Creates a report file, then deletes the report file.
	 * @throws \InvalidArgumentException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
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
