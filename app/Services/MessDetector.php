<?php

declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

/**
 * Executes PHP Mess Detector
 */
class MessDetector
{
	private const APP_DIRECTORY = 'app';

	private const CONFIG_FILE = 'phpmd.xml';

	public const DEFAULT_FILE_NAME = 'phpmd';

	private const EXECUTABLE = './vendor/bin/phpmd';

	private const RENDERERS = [
		'ansi',
		'github',
		'html',
		'json',
		'text',
		'xml',
	];

	public const REPORT_DIRECTORY = 'reports/';

	private const TYPES = [
		'html',
		'json',
		'xml',
	];

	private CommandLineProcessor $processor;

	private string $renderer = 'html';

	/**
	 * Sets the processor.
	 */
	public function __construct(CommandLineProcessor $processor)
	{
		$this->processor = $processor;
	}

	/**
	 * Deletes the existing report, executes the application, and saves the result as a report file.
	 * @param string|null $file
	 * @throws \InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function createReportFile(string $file = null): int
	{
		$this->deleteReport($file);
		$result = $this->execute();
		$this->processor->save(self::REPORT_DIRECTORY . $this->buildFileName($file));
		return $result;
	}

	/**
	 * Deletes a report with the given file name.
	 * @param string|null $file
	 * @throws \InvalidArgumentException
	 */
	final public function deleteReport(string $file = null): void
	{
		$path = self::REPORT_DIRECTORY . $this->buildFileName($file);
		if (!is_file($path)) {
			return;
		}

		unlink($path);
	}

	/**
	 * Builds a file name based on either the name passed or the default file name and the type.
	 * @param string|null $file
	 * @throws \InvalidArgumentException
	 */
	private function buildFileName(string $file = null): string
	{
		if (!in_array($this->renderer, self::TYPES)) {
			throw new InvalidArgumentException("{$this->renderer} cannot be saved as a file.");
		}

		if ($file === null) {
			return self::DEFAULT_FILE_NAME . ".{$this->renderer}";
		}

		$parts = explode('.', $file);
		if (count($parts) === 2) {
			return $file;
		}

		return "{$file}.{$this->renderer}";
	}

	/**
	 * Executes the PHPMD process.
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	private function execute(): int
	{
		return $this->processor->execute([
			self::EXECUTABLE,
			self::APP_DIRECTORY,
			$this->renderer,
			self::CONFIG_FILE
		]);
	}

	/**
	 * Displays the output of the process.
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function displayReport(): int
	{
		$result = $this->execute();
		$this->processor->display();
		return $result;
	}

	/**
	 * Sets the renderer as provided.
	 * @throws \InvalidArgumentException
	 */
	final public function setRenderer(string $renderer): void
	{
		if (!in_array($renderer, self::RENDERERS, true)) {
			throw new InvalidArgumentException("{$renderer} is not a valid PHPMD renderer.");
		}

		$this->renderer = $renderer;
	}
}
