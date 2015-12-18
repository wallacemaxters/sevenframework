<?php

namespace WallaceMaxters\SevenFramework\Controller;

abstract class Controller implements ControllerInterface
{
	private $request;

	public function getRequest() : Request
	{
		return $this->request;
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

}