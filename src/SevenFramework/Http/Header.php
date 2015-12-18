<?php

namespace WallaceMaxters\SevenFramework\Http;

use ArrayAccess;

class Header implements ArrayAccess
{
	protected $headers = [];

	protected $sent = false;

	public static function create(string $contentType = 'text/html', string $charset = 'utf-8')
	{

		$header = new static;

		$header->setContentType($contentType, $charset);

		return $header;
	}

	public function setContentType(string $contentType, string $charset = 'utf-8')
	{
		
		$this->set('content-type', sprintf('%s; charset=%s', $contentType, $charset));
	}

	public function getContentType(): string
	{
		return $this->get('content-type');
	}

	public function setContentLength(float $length)
	{
		$this->set('content-leght', $length);
	}

	public function setAllow(array $allowMethods)
	{
		$this->headers['allow'] = implode(', ', $allowedMethods);
	}

	public function getAllow(): string
	{
		return $this->get('allow');
	}

	public function setExpires(string $string)
	{
		$this->set('expires', $string);
	}

	public function setExpiresFromDateTime(\Datetime $datetime)
	{
		$this->setExpires($datetime->format('D, d M Y H:i:s'));
	}

	public function getExpires(): string
	{
		return $this->get('expires');
	}

	public function setPragma(string $pragma)
	{
		$this->set('pragma', $pragma);
	}

	public function getPragma(): string
	{
		return $this->get('pragma');
	}


	public function set($name, $value)
	{	
		$this->headers[static::parseFieldName($name)] = $value;

		return $this;
	}

	public function has($name): boolean
	{
		return array_key_exists(static::parseFieldName($name), $this->headers);
	}

	public function delete($name)
	{
		$value = $this->headers[$name];

		unset($this->headers[$name]);

		return $value;
	}

	public function get($name)
	{
		return $this->headers[static::parseFieldName($name)] ?? NULL;
	}

	protected static function parseFieldName(string $name): string
	{
		return mb_convert_case(str_replace('_', '-', $name), MB_CASE_TITLE);
	}

	public function offsetGet($name)
	{
		return $this->get($name);
	}

	public function offsetSet($name, $value)
	{
		return $this->set($name, $value);
	}

	public function offsetExists($name)
	{
		return $this->has($name);
	}

	public function offsetUnset($name)
	{
		$this->delete($name);
	}

	public function getAsArray(): array {

		$headers = [];

		foreach ($this->headers as $name => $value) {
	
			$headers[] = "{$name}: $value;";
		}

		return $headers;
	}


	public function setFromString(string $string)
	{
		list($name, $value) = explode(':', $string);

		$this->set($name, $value);
	}

}