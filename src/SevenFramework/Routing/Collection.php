<?php

namespace WallaceMaxters\SevenFramework\Routing;

use IteratorAggregate, ArrayIterator;

use WallaceMaxters\SevenFramework\Routing\Exceptions\RouteNotFoundException;

/**
 * Coleção de rotas
 * */
class Collection implements IteratorAggregate
{
	/**
	 * @var array
	 * */
	protected $items = [];

	/**
	* @param \WallaceMaxters\SevenFramework\Routing\Route $route
	* @return \WallaceMaxters\SevenFramework\Routing
	*/
	public function add(Route $route)
	{
		$this->items[] = $route;

		return $this;
	}

	/**
	* @return array
	*/	
	public function all() : array
	{
		return $this->items;
	}

	/**
	* @param string $pattern
	* @return \WallaceMaxters\SevenFramework\Routing\Route | null
	*/
	public function find(string $pattern)
	{

		foreach ($this->items as $route) {

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
		foreach ($this->items as $route) {

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


	public function merge(self $collection)
	{
		foreach ($collection as $route) {

			$this->add($route);
		}

		return $this;
	}

	public function getIterator() : ArrayIterator
	{
		return new ArrayIterator($this->items);
	}
}