<?php

namespace App\Console\Commands;

use App\Services\MessDetector;
use Illuminate\Console\Command;

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
		$this->messDetector->setRenderer('xml');
		return $this->messDetector->createReportFile();
	}
}
