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
		$this->sendHeaders();

		$this->sendContent();

		return $this;
	}

	public function sendHeaders()
	{
		if (! $this->sent()) {

			$this->sent = true;

			http_response_code($this->statusCode);

			foreach ($this->getHeader()->getAsArray() as $value) {

				header($value);
			}
		}

		return $this;
	}

	public function sendContent()
	{
		echo $this->getContent();

		return $this;
	}

	public function sent()
	{
		return $this->sent || headers_sent();
	}

	public static function json(...$arguments)
	{
		return new JsonResponse(...$arguments);
	}

}