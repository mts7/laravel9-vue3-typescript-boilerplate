<?php

namespace Tests\App\Services;

use App\Services\CommandLineProcessor;
use App\Services\MessDetector;
use InvalidArgumentException;
use Tests\TestCase;

class MessDetectorTest extends TestCase
{
	private MessDetector $messDetector;

	public function setUp(): void
	{
		parent::setUp();
		$processor = $this->getMockBuilder(CommandLineProcessor::class)
			->disableOriginalConstructor()
			->getMock();
		$processor->method('execute')->willReturn(1);
		$this->messDetector = new MessDetector($processor);
	}

	public function testCreateReportFileWithNullName()
	{
		$result = $this->messDetector->createReportFile();
		$this->assertEquals(1, $result);
	}

	public function testCreateReportFileWithNamePart()
	{
		$result = $this->messDetector->createReportFile('name');
		$this->assertEquals(1, $result);
	}

	public function testCreateReportFileWithFullName()
	{
		$result = $this->messDetector->createReportFile('name.ext');
		$this->assertEquals(1, $result);
	}

	public function testCreateReportFileWithInvalidRenderer()
	{
		$renderer = 'ansi';
		$this->messDetector->setRenderer($renderer);

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} cannot be saved as a file.");

		$this->messDetector->createReportFile('name');
	}

	public function testDisplayReport(): void
	{
		$value = $this->messDetector->displayReport();
		$this->assertEquals(1, $value, 'Mock was not set up properly.');
	}

	final public function testSetRendererSuccess(): void
	{
		$renderer = 'text';
		$exception = null;
		try {
			$this->messDetector->setRenderer($renderer);
		} catch (InvalidArgumentException $exception) {
			// this should never execute
		}

		$message = $exception instanceof InvalidArgumentException ? $exception->getMessage() : '';
		$this->assertNull($exception, $message);
	}

	final public function testSetRendererFail(): void
	{
		$renderer = 'invalid';

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("{$renderer} is not a valid PHPMD renderer.");

		$this->messDetector->setRenderer($renderer);
	}
}
