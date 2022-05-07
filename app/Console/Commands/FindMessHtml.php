<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\MessDetector;
use Illuminate\Console\Command;

/**
 * Executes PHP Mess Detector and saves the results.
 */
class FindMessHtml extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phpmd:html';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Executes PHPMD and stores the HTML report in the reports directory';

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
		$this->messDetector->setRenderer('html');
		return $this->messDetector->createReportFile();
	}
}
