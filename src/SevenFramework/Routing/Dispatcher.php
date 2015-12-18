<?php


namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\TraitHelpers\CreateObjectTrait;

use WallaceMaxters\SevenFramework\Http\Request;

use WallaceMaxters\SevenFramework\Http\Response;

use WallaceMaxters\SevenFramework\View\View;

use UnexpectedValueException;


class Dispatcher
{
	/**
	 * 
	 * @var WallaceMaxters\SevenFramework\Http\Request;
	 **/
	protected $request;

	protected $route;

	public function __construct(Request $request, Route $route)
	{
		$this->request = $request;

		$this->route = $route;
	}

	public function getResponse()
	{
		$path = $this->request->getPathinfo();

		$parameters = $this->route->getParameters($path);

		$action = $this->route->getAction();

		if ($action instanceof \Closure) {

			// Lembrar de passar o request 

			$response = $action(...$parameters);

		} else {

			$controller = new $action[0]();

			$method = $action[1];

			$response = $controller->$method(...$parameters);
		}


		if (! $response instanceof Response) {

			$response = new Response((string)$response, 200);
		}

		return $response;

	}
}