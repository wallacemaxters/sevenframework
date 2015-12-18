<?php

namespace WallaceMaxters\SevenFramework\View;

use ArrayIterator;
use SplObjectStorage;
use IteratorAggregate;

class SectionCollection implements IteratorAggregate
{

	protected $sections = [];

	public function find(string $name)
	{
		if (isset($this->sections[$name])) {

			return $this->sections[$name];

		}
		return false;
	}


	public function findOrCreate(string $name)
	{
		$section = $this->find($name);

		if (! $section) {

			$section = new Section($name);

			$this->attach($section);
		}

		return $section;
	}

	public function getIterator()
	{
		return new ArrayIterator($this->sections);
	}

	public function attach(Section $section)
	{
		$this->sections[$section->getName()] = $section;
	}

	public function detach(Section $section)
	{
		unset($this->sections[$section->getName()]);
	}

	public function detachByName(string $name)
	{
		unset($this->sections[$name]);
	}

	public function pop(string $name = null)
	{	
		if (! $name) {
			return array_pop($this->sections);
		}

		$section = $this->find($name);

		if (! $section) {

			return null;
		}

		$this->detach($section);

		return $section;
	}

	public function last()
	{
		return end($this->sections);
	}

	public function clear()
	{
		$this->sections = [];
	}
}
