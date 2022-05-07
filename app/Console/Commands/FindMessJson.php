<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\MessDetector;
use Illuminate\Console\Command;

/**
 * Executes PHP Mess Detector and saves the results.
 */
class FindMessJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'phpmd:json';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Executes PHPMD and stores the JSON report in the reports directory';

	private MessDetector $messDetector;

	public function __construct(MessDetector $messDetector)
	{
		parent::__construct();
		$this->messDetector = $messDetector;
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	final public function handle(): int
	{
		$this->messDetector->setRenderer('json');
		return $this->messDetector->createReportFile();
	}
}
