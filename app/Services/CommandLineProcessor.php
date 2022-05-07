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
	 */
	public function display(): void
	{
		echo $this->process->getOutput() . PHP_EOL;
	}

	/**
	 * Executes the mess detector.
	 */
	public function execute(array $command): int
	{
		$this->process = new Process($command);
		return $this->process->run();
	}

	/**
	 * Saves the report output to the specified path.
	 * @param string|null $file
	 */
	public function save(string $file = null): void
	{
		file_put_contents($file, $this->process->getOutput());
	}
}
