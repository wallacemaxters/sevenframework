<?php

namespace WallaceMaxters\SevenFramework\Routing;

class Router
{
	/**
	 * @var string
	 *
	 * */
	protected $basePath = '';	


	/**
	 * @var \WallaceMaxters\SevenFramework\Routing\RouteCollection
	 *
	 * */

	protected $routes;


	public function __construct(Collection $routes)
	{
		$this->routes = $routes;
	}

	public function setBasepath(string $basePath)
	{
		$this->basePath = rtrim($basePath, '/');
	}

	public function match(string $requestUrl, string $requestMethod = 'GET')
	{	
		
		// Determine the prefix for collection

		$requestUrl = $this->basePath . $requestUrl;

		$route = $this->routes->first(function ($route) use($requestUrl, $requestMethod)
		{
			return $route->match($requestUrl) && $route->isAcceptedMethod($requestMethod);
		});


		if ($route === false) {

			return false;
		}

		return $route;

	}

	public function matchRequest(Request $request)
	{
		return $this->match($request->getUri(), $request->getMethod());
	}

}