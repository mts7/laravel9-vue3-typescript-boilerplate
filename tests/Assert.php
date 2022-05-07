<?php

declare(strict_types=1);

namespace Tests;

trait Assert
{
	/**
	 * Asserts if the callable does not throw an exception.
	 */
	final public function assertNoException(callable $callable): void
	{
		$exception = null;
		try {
			$callable();
		} catch (\Throwable $exception) {
			// this should never execute
		}

		$message = $exception instanceof \Throwable ? $exception->getMessage() : '';
		$this->assertNull($exception, $message);
	}
}
