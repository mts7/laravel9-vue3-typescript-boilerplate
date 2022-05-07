<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\PsalmRunner;
use Illuminate\Console\Command;

/**
 * Checks for errors from psalm.
 */
class PsalmErrors extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'psalm:errors';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Display errors found by psalm';

	private PsalmRunner $runner;

	/**
	 * Constructor
	 */
	public function __construct(PsalmRunner $runner)
	{
		parent::__construct();
		$this->runner = $runner;
	}

	/**
	 * Execute the console command.
	 *
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function handle(): int
	{
		return $this->runner->displayReport();
	}
}
