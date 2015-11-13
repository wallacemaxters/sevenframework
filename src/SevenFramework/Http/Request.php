<?php

namespace WallaceMaxters\SevenFramework\Http;

/**
 * Representa a requisição do cliente
 * */

class Request
{

	/**
	 * @var Header
	 * */
	protected $header;


	public function __construct(Header $header = null)
	{
		$this->setHeader($header ?? new Header);
	}

	public function setHeader(Header $header)
	{
		$this->header = $header;

		return $header;
	}

	public function isMethod($method)
	{
		return $this->getMethod() == strtoupper($method);
	}

	public function getMethod(): string
	{
		return filter_input(INPUT_SERVER, 'REQUEST_METHOD') ?? 'GET';
	}

	public function getHeader()
	{
		return $this->header;
	}

	public static function getUri()
	{
		return filter_input(INPUT_SERVER, 'REQUEST_URI');
	}

	public function getPathinfo()
	{
		return filter_input(INPUT_SERVER, 'PATH_INFO') ?? '/';
	}

	public static function getQuery(string $name, ...$arguments)
	{
		return filter_input(INPUT_GET, $name, ...$arguments);
	}

	public static function getPost(string $name, ...$arguments)
	{
		return filter_input(INPUT_GET, $name, ...$arguments);
	}

	public static function getServer(string $name, ...$arguments)
	{
		return filter_input(INPUT_SERVER, $name, ...$arguments);
	}

	

}