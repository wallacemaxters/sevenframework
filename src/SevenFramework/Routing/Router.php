<?php

namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\Http\Request;

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

	public function findRoute(string $requestUrl, string $requestMethod = 'GET')
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

	public function findRouteByRequest(Request $request)
	{
		return $this->findRoute($request->getPathinfo(), $request->getMethod());
	}

	public function dispatchToRoute(Request $request)
	{
		$route = $this->findRouteByRequest($request);

		if ($route === false) {

			throw new \Exception('Rota não existe');
		}

		//$route->callEvent('before', $request);

		$response = (new Dispatcher($request, $route))->getResponse();

		//$route->callEvent('after', $request, $response);

		return $response;

	}

}