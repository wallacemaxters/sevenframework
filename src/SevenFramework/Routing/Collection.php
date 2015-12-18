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
	 * @var \SplObjectStorage
	 * */
	protected $storage;

	protected $ignoreds;

	public function __construct()
	{
		$this->storage = new SplObjectStorage;
	}

	public function add(Route $route)
	{
		$this->storage->attach($route, $route->getParsedPattern());

		return $this;
	}

	public function all() : SplObjectStorage
	{
		return $this->storage;
	}

	public function find(string $pattern)
	{

		foreach ($this->storage as $route) {

			if ($route->match($pattern)) {

				return $route;
			}
		}
	}

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