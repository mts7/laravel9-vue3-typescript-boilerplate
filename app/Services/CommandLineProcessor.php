<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Process\Process;

/**
 * Wrapper of Process to handle executing commands.
 */
class CommandLineProcessor
{
	private Process $process;

	/**
	 * Displays the output from the process.
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 */
	final public function display(): void
	{
		echo $this->process->getOutput() . PHP_EOL;
	}

	/**
	 * Executes the mess detector.
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function execute(array $command): int
	{
		$this->process = new Process($command);
		return $this->process->run();
	}

	/**
	 * Saves the report output to the specified path.
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 */
	final public function save(string $file): void
	{
		file_put_contents($file, $this->process->getOutput());
	}
}
