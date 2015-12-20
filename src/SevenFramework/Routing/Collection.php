<?php

namespace WallaceMaxters\SevenFramework\Routing;

use SplObjectStorage;
use ArrayAccess;

use WallaceMaxters\SevenFramework\Routing\Exceptions\RouteNotFoundException;

/**
 * Coleção de rotas
 * */
class Collection
{
	/**
	 * @var array
	 * */
	protected $storage = [];

	public function __construct()
	{
	}

	/**
	* @param \WallaceMaxters\SevenFramework\Routing\Route $route
	* @return \WallaceMaxters\SevenFramework\Routing
	*/
	public function add(Route $route)
	{
		$this->storage[] = $route;

		return $this;
	}

	/**
	* @return array
	*/	
	public function all() : array
	{
		return $this->storage;
	}

	/**
	* @param string $pattern
	* @return \WallaceMaxters\SevenFramework\Routing\Route | null
	*/
	public function find(string $pattern)
	{

		foreach ($this->storage as $route) {

			if ($route->match($pattern)) {

				return $route;
			}
		}
	}

	/**
	* @param Closure $callbak
	* @return \WallaceMaxters\SevenFramework\Routing\Route | null 
	*/
	public function first(\Closure $callback)
	{
		foreach ($this->storage as $route) {

			if ($callback($route)) {

				return $route;
			}
		}

		return false;
	}

	public function findOrFail(string $pattern) : Route
	{
		$route = $this->find($pattern);

		if (! $route) {

			throw new RouteNotFoundException('Route not found');
			
		}

		return $route;

	}
}