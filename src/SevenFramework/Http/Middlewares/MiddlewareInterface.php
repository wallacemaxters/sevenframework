<?php

namespace WallaceMaxters\SevenFramework\Http\Middlewares;

use WallaceMaxters\SevenFramework\Http\Request;

interface MiddlewareInterface
{

	public function processRequest(Request $request, callable $callback);

	public function processResponse(Response $response, callable $callback);
}