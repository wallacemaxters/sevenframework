<?php

namespace WallaceMaxters\SevenFramework\Http\Parameters;

class Header extends Parameters
{

	public function set(string $name, $value)
	{
		$name = $this->parseFieldName($name);

		return parent::set($name, $value);		
	}

	public function get(string $name)
	{

		$name = $this->parseFieldName($name);

		return parent::get($name);
	}

	protected function parseFieldName(string $name): string
	{
		return mb_convert_case(str_replace('_', '-', $name), MB_CASE_TITLE	);
	}

	public function getAsArray(): array 
	{

		$headers = [];

		foreach ($this->all() as $name => $value) {
	
			foreach ((array) $value as $v) {
				
				$headers[] = "{$name}: {$v}";
			}
		}

		return $headers;
	}

	public function setContentType(string $contentType, string $charset = 'utf-8')
	{
		if ($charset === '') {

			$this->set('content-type', $contentType);

		} else {

			$this->set('content-type', sprintf('%s; charset=%s', $contentType, $charset));
		}

	}

	public function getContentType(): string
	{
		return $this->get('content-type');
	}

}