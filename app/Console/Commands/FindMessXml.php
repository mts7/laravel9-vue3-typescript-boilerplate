<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\MessDetector;
use Illuminate\Console\Command;

/**
 * Executes PHP Mess Detector and saves the results.
 */
class FindMessXml extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phpmd:xml';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Executes PHPMD and stores the XML report in the reports directory';

	private MessDetector $messDetector;

	/**
	 * Constructor
	 */
	public function __construct(MessDetector $messDetector)
	{
		parent::__construct();
		$this->messDetector = $messDetector;
	}

	/**
	 * Execute the console command.
	 *
	 * @throws \InvalidArgumentException
	 * @throws \Symfony\Component\Process\Exception\LogicException
	 * @throws \Symfony\Component\Process\Exception\ProcessSignaledException
	 * @throws \Symfony\Component\Process\Exception\ProcessTimedOutException
	 * @throws \Symfony\Component\Process\Exception\RuntimeException
	 */
	final public function handle(): int
	{
		$this->messDetector->setRenderer('xml');
		return $this->messDetector->createReportFile();
	}
}
