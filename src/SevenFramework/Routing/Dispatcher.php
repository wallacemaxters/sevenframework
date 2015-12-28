<?php


namespace WallaceMaxters\SevenFramework\Routing;

use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\Http\Response;
use WallaceMaxters\SevenFramework\Http\Exceptions\HttpException;
use WallaceMaxters\SevenFramework\View\View;
use UnexpectedValueException;
use WallaceMaxters\SevenFramework\Controller\Controller;

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

			$nullController = new Controller;

			$nullController->setRequest($this->request);

			$response = $action->call($nullController, ...$parameters);

		} else {

			$controller = new $action[0]();

			$controller->setRequest($this->request);

			$method = $action[1];

			$response = $controller->$method(...$parameters);
		}

		

		if (! $response instanceof Response) {

			$response = new Response((string)$response, 200);
		}

		return $response->send();

	}
}