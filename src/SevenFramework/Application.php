<?php

namespace WallaceMaxters\SevenFramework;

use Throwable;
use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\Routting;
use WallaceMaxters\SevenFramework\Exceptions\ExceptionHandlerInterface;

class Application extends Container
{

	public function __construct(Request $request = null, Router $router = null)
	{
		$this->setRequest($request ?? new Request);
		$this->setRouter($router ?? new Router);
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function setRouter(Router $router)
	{
		$this->router = $router;
	}

	public function getRouter()
	{
		return $this->router;
	}

	public function handleException(Throwable $e)
	{
		return $this->getExceptionHandler()
					->setExcepton($e)
					->output();
	}

	public function setExceptionHandler(ExceptionHandlerInterface $handler)
	{
		$this->exceptionHandler = $handler;
	}

	public function getExceptionHandler()
	{
		return $this->exceptionHandler;
	}

	public function run()
	{
		$request = $this->getRequest();

		foreach ($this->getBeforeCallbacks() as $callback) {

			$callback->call($this, $request);
		}

		$response = $this->getRouter()->dispatchToRoute($request);

		foreach ($this->getAfterCallbacks() as $callback) {

			$callback->call($this, $request, $response);
		}
	}

}

