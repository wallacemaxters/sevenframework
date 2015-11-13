<?php

namespace WallaceMaxters\SevenFramework\Http;

class Response
{
	/**
	 * @var class
	 * */
	protected $header;

	/**
	 * @var string
	 **/
	protected $content;

	/**
	 * Http protocol version
	 * @var string
	 **/
	protected $version;


	protected $sent = false;

	public function __construct(string $content = '', int $status = 200) {

		$this->setStatusCode($status);

		$this->setContent($content);
	}

	public function setHeader(Header $header)
	{
		$this->header = $header;
	}

	public function getHeader()
	{
		if (! $this->header) {

			$this->header = new Header;
		}

		return $this->header;
	}

	public function setStatusCode(int $status)
	{
		$this->statusCode = $status;
	}

	public function getStatusCode(): int{
		return $this->statusCode;
	}

	public function setProtocolVersion(float $version)
	{
		$this->version = $version;
	}

	public function setContent(string $content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function send()
	{

		if (! $this->sent()) {

			$this->sent = true;

			http_response_code($this->statusCode);

			foreach ($this->getHeader()->getAsArray() as $value) {

				header($value);
			}
		}

		echo $this->getContent();

		return $this;
	}

	public function sent()
	{
		return $this->sent || headers_sent();
	}

	public static function create(string $content = '', int $status = 200, callable $callback = null)
	{
		$response = new static($content, $status);

		$header = new Header;

		$response->setHeader($header);

		if ($callback !== null) {

			$callback($response, $header);
		}

		return $response;

	}

	public static function json($data, $status = 200, array $headers = [])
	{

		$json = json_encode($data);

		$response = new static($json, $status);

		$header = new Header;

		foreach ($headers as $name => $value) {

			$header->set($name, $value);
		}

		$header->setContentType('application/json');

		$response->setHeader($header);

		return $response;

	}

}