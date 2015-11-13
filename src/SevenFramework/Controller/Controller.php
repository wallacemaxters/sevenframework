<?php

namespace WallaceMaxters\SevenFramework\Controller;

abstract class Controller
{

	private $request;

	private $response;

	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;

		$this->response = $response;
	}


	public function getRequest() : Request
	{
		return $this->request;
	}

	public function getResponse() : Response
	{
		return $this->response;
	}



}