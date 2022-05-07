<?php

declare(strict_types=1);

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\IndexController;
use Inertia\Inertia;
use Inertia\Response;
use Mockery;
use Tests\TestCase;

/**
 * Tests the index controller.
 *
 * @group controller
 * @group inertia
 */
class IndexControllerTest extends TestCase
{
	/**
	 * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface
	 */
	private mixed $inertiaMock;
	/**
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 * @throws \Illuminate\Contracts\Container\CircularDependencyException
	 * @throws \PHPUnit\Framework\ExpectationFailedException
	 * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
	 */
	final public function testIndex(): void
	{
		/** @var IndexController $controller */
		$controller = $this->app->make(IndexController::class);
		$response = $controller->index();
		$this->inertiaMock->shouldHaveReceived('render', ['Index']);
		$this->assertStringContainsString('Response', get_class($response), 'Mock is incorrect.');
	}
	/**
	 * Sets up mocks for Inertia.
	 */
	protected function setUp(): void
	{
		parent::setUp();
		$this->inertiaMock = Mockery::mock('overload:' . Inertia::class);
		$this->inertiaMock->shouldReceive('render')
			->andReturn(Mockery::mock(Response::class));
	}
}
