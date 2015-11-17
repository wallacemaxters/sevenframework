<?php

namespace WallaceMaxters\SevenFramework\Http;

use WallaceMaxters\SevenFramework\Routing\Router;
use WallaceMaxters\SevenFramework\Exceptions\HttpNotFoundException;
use WallaceMaxters\SevenFramework\Routing\Collection as RouteCollection;
use WallaceMaxters\SevenFramework\TraitHelpers\CreateObjectTrait;

class HttpKernel
{
	use CreateObjectTrait;

	protected $router;

	protected $request;

	protected $debug = false;

	protected $shutdownEvents = [];

	public function __construct(Request $request = null)
	{
		$this->request = $request ?? new Request;
	}

	public function start()
	{
		
	}

	public function enableDebug()
	{
		$this->debug = true;
	}

	public function disableDebug()
	{
		$this->debug = false;
	}

	public function routes(\Closure $callback)
	{
		$this->router = new Router(new RouteCollection);

		$callback->call($this, $this->router);

		return $this;
	}

	public function runShutdownEvents(Response $response = null)
	{
		foreach ($this->shutdownEvents as $shutdown) {

			$shutdown($response);
		}	
	} 

	public function runBeforeEvents()
	{}


	public function addShutdownEvent(callable $callback)
	{
		$this->shutdownEvents[] = $callback;

		return $this;
	}

	public function before(callable $callback)
	{
		$this->beforeActions[] = $callback;
	}

	public function after(callable $callback)
	{

	}

	public function run()
	{

		$this->runBeforeEvents();

		try {

			$response = $this->router->dispatchToRoute($this->request);

		} catch (HttpNotFoundException $e) {

			return $this->handleException($e);

		} catch (Throwable $e) {

			return $this->handleException($e);
		}

		$response->sendHeaders();

		$response->sendContent();

		$this->runShutdownEvents($response);
	}

	protected function handleException($exception)
	{

		if ($exception instanceof HttpNotFoundException) {

			$status = '404 - Not found';

		} else {

			$status = '500 - Internal server error';
		}

		$format = '<h1>%s</h1><pre style="color:#800">%s</pre>';
		
		$response = new Response(sprintf($format, $status, $exception->getMessage()), 500);

		$response->sendHeaders();

		$response->sendContent();

		$this->runShutdownEvents($response);
	}

}