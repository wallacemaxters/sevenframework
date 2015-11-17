<?php

namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\Http\Request;

use WallaceMaxters\SevenFramework\Exceptions\HttpNotFoundException;


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

			throw new HttpNotFoundException('Rota não existe');
		}

		//$route->callEvent('before', $request);

		$response = (new Dispatcher($request, $route))->getResponse();

		//$route->callEvent('after', $request, $response);

		return $response;

	}

	public function addRoute(array $methods, string $pattern, $action)
	{
		$newRoute = new Route($pattern, $action);

		$newRoute->setMethods($methods);

		$this->routes->add($newRoute);

		return $this;
	}


	public function get(string $pattern, $action)
	{
		return $this->addRoute(['GET', 'HEAD'], $pattern, $action);
	}

	public function put(string $pattern, $action)
	{
		return $this->addRoute(['PUT'], $pattern, $action);
	}

	public function post(string $pattern, $action)
	{
		return $this->addRoute(['POST'], $pattern, $action);
	}

	public function delete(string $pattern, $action)
	{
		return $this->addRoute(['DELETE'], $pattern, $action);
	}

}