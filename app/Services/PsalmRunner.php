<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Executes Psalm
 */
class PsalmRunner
{
	private const CONFIG_FILE = 'psalm.xml';

	private const EXECUTABLE = './vendor/bin/psalm';

	private CommandLineProcessor $processor;

	/**
	 * Sets the processor.
	 */
	public function __construct(CommandLineProcessor $processor)
	{
		$this->processor = $processor;
	}

	/**
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function displayReport(array $arguments = []): int
	{
		$result = $this->execute($arguments);
		$this->processor->display();
		return $result;
	}

	/**
	 * Executes the psalm process.
	 *
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	private function execute(array $arguments = []): int
	{
		$command = [
			self::EXECUTABLE,
			'-c',
			self::CONFIG_FILE,
		];
		return $this->processor->execute(array_merge($command, $arguments));
	}
}
