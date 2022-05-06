<?php

namespace App\Services;

use Symfony\Component\Process\Process;

class CommandLineProcessor
{
	private Process $process;

	public function display(): void
	{
		echo $this->process->getOutput() . PHP_EOL;
	}

	/**
	 * Executes the mess detector.
	 * @param array $command
	 * @return int
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
