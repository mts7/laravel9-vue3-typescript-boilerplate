<?php

namespace App\Console\Commands;

use App\Services\MessDetector;
use Illuminate\Console\Command;

class FindMessAnsi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpmd:ansi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes PHPMD and displays the report on the screen';

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
		$this->messDetector->setRenderer('ansi');
		return $this->messDetector->displayReport();
	}
}
