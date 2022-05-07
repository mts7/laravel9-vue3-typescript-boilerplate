<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/**
 * Example controller for Inertia loading
 */
class IndexController extends Controller
{
	/**
	 * Renders the Index Vue component with Inertia.
	 */
    final public function index(): Response
	{
        return Inertia::render('Index');
    }
}
