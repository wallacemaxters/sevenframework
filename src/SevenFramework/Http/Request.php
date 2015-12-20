<?php

namespace WallaceMaxters\SevenFramework\Http;

/**
 * Representa a requisição do cliente
 * */

class Request
{

	protected $method = 'GET';

	protected $server;

	protected $inputs = [
		'get'    => [],
		'post'   => [],
		'cookie' => [],
		'server' => [],
	];

	public function isMethod($method)
	{
		return $this->getMethod() == strtoupper($method);
	}

	// public static function getMethod(): string
	// {
	// 	return filter_input(INPUT_SERVER, 'REQUEST_METHOD') ?? 'GET';
	// }

	// public function getHeader()
	// {
	// 	return $this->header;
	// }

	// public static function getUri()
	// {
	// 	return filter_input(INPUT_SERVER, 'REQUEST_URI');
	// }

	// public function getPathinfo()
	// {
	// 	return filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
	// }

	public function setMethod(string $method)
	{
		$this->method = strtoupper($method);
	}

	public function getMethod() : string
	{
		return $this->method;
	}

	public function setQuery(array $query)
	{
		$this->query = $query;

		return $this;
	}

	public function getQuery(string $name = null)
	{
		if ($name === null) {

			return $this->query;
		}

		return $this->query[$name] ?? null;
	}

	public function setInput(array $input)
	{
		$this->input = $input;

		return $this;
	}


	public function getInput(string $name = null)
	{
		if ($name === null) {

			return $this->input;
		}

		return $this->input[$name] ?? null;
	}

	public function setServer(array $server)
	{
		$this->server = $server;

		return $this;
	}

	public function getServer(string $name)
	{

		if ($name === null) {

			return $this->server;
		}

		return $this->server[$name] ?? null;
	}


	public function setCookie(array $cookie)
	{
		$this->cookie  = $cookie;

		return $this;
	}

	public static function createFromGlobals()
	{

		$request = new self();

		$request->setQuery($_GET)
				 ->setInput($_POST)
				 ->setServer($_SERVER)
				 ->setCookie($_COOKIE)
				 ->setMethod($_SERVER['REQUEST_METHOD'] ?? 'GET');

		return $request;

	}


	public function getUri()
	{
		return $this->server['REQUEST_URI'] ?? '/';
	}

	public function getPathinfo()
	{
		return $this->server['PATH_INFO'] ?? '/';
	}

}