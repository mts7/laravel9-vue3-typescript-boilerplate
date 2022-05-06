<?php

namespace App\Services;

use InvalidArgumentException;

class MessDetector
{
	private const APP_DIRECTORY = 'app';

	private const CONFIG_FILE = 'phpmd.xml';

	private const DEFAULT_FILE_NAME = 'phpmd';

	private const EXECUTABLE = './vendor/bin/phpmd';

	private const REPORT_DIRECTORY = 'reports/';

	private const RENDERERS = [
		'ansi',
		'github',
		'html',
		'json',
		'text',
		'xml',
	];

	private const TYPES = [
		'html',
		'json',
		'xml',
	];

	private CommandLineProcessor $processor;

	private string $renderer = 'html';

	public function __construct(CommandLineProcessor $processor)
	{
		$this->processor = $processor;
	}

	/**
	 * Deletes the existing report, executes the application, and saves the result as a report file.
	 * @param string|null $file
	 * @return int
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
	 */
	private function deleteReport(string $file = null): void
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
	 * @return string
	 */
	private function buildFileName(string $file = null): string
	{
		if (!in_array($this->renderer, self::TYPES)) {
			throw new InvalidArgumentException("{$this->renderer} cannot be saved as a file.");
		}

		$parts = explode('.', $file);
		if (count($parts) === 2) {
			return $file;
		}

		if (is_null($file)) {
			return self::DEFAULT_FILE_NAME . ".{$this->renderer}";
		}

		return "{$file}.{$this->renderer}";
	}

	/**
	 * Executes the PHPMD process.
	 * @return int
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
	 * @return int
	 */
	final public function displayReport(): int
	{
		$result = $this->execute();
		$this->processor->display();
		return $result;
	}

	/**
	 * Sets the renderer as provided.
	 * @param string $renderer
	 * @return void
	 */
	final public function setRenderer(string $renderer): void
	{
		if (!in_array($renderer, self::RENDERERS, true)) {
			throw new InvalidArgumentException("{$renderer} is not a valid PHPMD renderer.");
		}

		$this->renderer = $renderer;
	}
}
