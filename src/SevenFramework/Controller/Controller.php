<?php

namespace WallaceMaxters\SevenFramework\Controller;

use WallaceMaxters\SevenFramework\Http\{Request, Response};
use WallaceMaxters\SevenFramework\View\View;

class Controller implements ControllerInterface
{
	/**
	* @var \WallaceMaxters\SevenFramework\Http\Request
	*/
	private $request;

	/**
	* @param \WallaceMaxters\SevenFramework\Http\Request $request
	* @return void
	*/
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	/**
	* @return \WallaceMaxters\SevenFramework\Http\Request
	*/
	public function getRequest() : Request
	{
		return $this->request;
	}


	public function render(string $name, array $data = []) : View
	{
		return new View($name, $data);
	}

	public function redirect()
	{
		return new Redirector($this->request);
	}

}