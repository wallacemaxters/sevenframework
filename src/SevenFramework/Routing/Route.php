<?php

namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\Exceptions\ControllerNotFoundException;

use WallaceMaxters\SevenFramework\Http\Request;

/**
 * Representa uma rota
 * 
 * */
class Route implements RouteInterface
{

	protected $methods = ['*'];

	/**
	 * @var string
	 * */
	protected $pattern;

	/**
	 * @var callable
	 **/
	protected $action;

	/**
	 * The name of route
	 * @var string
	 * */

	protected $name = null;

	/**
	 *@var array
	 * */
	protected $filters = [];


	const ANY_METHOD_WILDCARD = '*';

	public function __construct(string $pattern, $action = null, array $methods = ['*'])
	{
		$this->setPattern($pattern);

		$this->setMethods($methods);

		$this->setAction($action);
	}

	public function setAction ($action)
	{
		if ($action instanceof \Closure) {

			$this->action = $action;

			return;
		}

		$parts = explode('::', $action);

		if (count($parts) != 2) {

			throw new LengthException('Malformed action string');
		}

		if (! class_exists($parts[0])) {

			throw new ControllerNotFoundException("Controller {$parts[0]} doesn't exist");
		}

		if (! method_exists($parts[0], $parts[1])) {

			throw new InvalidArgumentException("Action {$parts[1]} doesn't exist");
		}

		$this->action = $parts;

	}


	public function setPattern(string $pattern)
	{	
		$this->pattern = $pattern;
	}

	public function getPattern() : string
	{
		return $this->pattern;
	}

	public function setMethod(string $method)
	{
		$this->setMethods([$method]);

		return $this;
	}

	public function setMethods(array $methods)
	{
		$this->methods = $methods;
	}

	public function getMethods() : array
	{
		return $this->methods;
	}

	public function isAcceptedMethod($method) : bool
	{	

		if (isset($this->methods[0]) && $this->methods[0] == static::ANY_METHOD_WILDCARD) {

			return true;
		}

		return in_array(strtoupper($method), $this->getMethods());
	}

	public function getAction()
	{
		return $this->action;
	}

	public function getActionAsCallable(): callable
	{
		if ($this->action instanceof \Closure) {

			return $this->action;
		}

		return [new $this->action[0], $this->action[1]];
	}

	public function getParsedPattern() : string
	{
		return '/^\/?' . strtr($this->pattern, static::PATTERN_TRANSLATION) . '\/?$/';
	}

	public function match(string $url) : bool
	{
		return preg_match($this->getParsedPattern(), trim($url)) > 0;
	}

	public function getParameters(string $url)
	{
		preg_match($this->getParsedPattern(), $url, $matches);

		return array_slice($matches, 1);
	}

	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	public function hasName() : bool
	{
		return $this->name !== null;
	}

	public function getName() : string 
	{

		return $this->name;
	}

	public function setFilters(string ...$filters)
	{
		$this->filters = $filter;
	}

	public function getFilters()
	{
		return $this->filters;
	}

}