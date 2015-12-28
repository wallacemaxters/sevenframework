<?php

namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\Http\Request;

use WallaceMaxters\SevenFramework\Http\Exceptions\{HttpException, NotFoundException};


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

	/**
	 * @var array
	 * */
	protected $filters = [];


	public function __construct(Collection $routes = null)
	{	
		$this->routes = $routes ?? new Collection;
	}

	public function setBasepath(string $basePath)
	{
		$this->basePath = rtrim($basePath, '/');
	}


	public function findRoute(string $requestUrl)
	{	
		
		$route = $this->routes->first(function ($route) use($requestUrl)
		{
			return $route->match($requestUrl);
		});

		return $route;

	}

	public function findRouteByRequest(Request $request)
	{
		return $this->findRoute($request->getPathinfo());
	}

	/**
	* Returns route by given name
	* @param string $name
	*/
	public function findRouteByName(string $name)
	{
		return $this->routes->first(function ($route) use($name)
		{
			return $route->getName() === $name;
		});
	}

	public function dispatchToRoute(Request $request)
	{
		$route = $this->findRouteByRequest($request);

		if ($route === false) {

			throw new NotFoundException('Rota não existe');

		} elseif (! $route->isAcceptedMethod($request->getMethod())) {

			throw new HttpException('Method not allowed', 405);
		}

		/** 
		* @todo Chamar as filtros somente se existir na rota
		* **/
		foreach ($route->getFilters() as $name) {

			$callable = $this->getFilter($name);
		}

		$response = (new Dispatcher($request, $route))->getResponse();

		return $response;

	}


	public function addRoute(array $methods, string $pattern, $action)
	{

		$pattern = trim($this->basePath . '/' . $pattern, '/');

		$newRoute = new Route($pattern, $action);

		$newRoute->setMethods($methods);

		$this->routes->add($newRoute);

		return $newRoute;
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

	public function prefixes(string $prefix, \Closure $closure)
	{
		$newRouter = new static();

		$newRouter->setBasepath($prefix);

		$closure->call($newRouter);

		$this->getCollection()->merge($newRouter->getCollection());

		return $this;
	}

	public function getCollection() : Collection
	{
		return $this->routes;
	}

}