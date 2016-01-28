<?php

namespace WallaceMaxters\SevenFramework\Http\Parameters;

use Iterator,
	ArrayIterator,
	ArrayAccess,
	Countable,
	IteratorAggregate;



class Parameters implements ArrayAccess, Countable, IteratorAggregate
{

	protected $items = [];

	public function __construct(array $items = [])
	{
		$this->replace($items);
	}

	public function set(string $key, $value)
	{
		$this->items[$key] = $value;

		return $this;
	}

	public function append($value)
	{
		$this->items[] = $value;

		return $this;
	}

	public function get(string $key)
	{
		return $this->items[$key] ?? null;
	}

	public function has(string $key)
	{
		return isset($this->items[$key]);
	}

	public function delete(string $key)
	{
		unset($this->items[$key]);

		return $this;
	}

	public function isEmpty() : boolean
	{
		return empty($this->items);
	}

	public function count() : int
	{
		return count($this->items);
	}

	public function replace(array $items)
	{
		$this->items = $items;

		return $this;
	}

	public function merge(array $items)
	{
		$this->items = $items + $this->items;

		return $this;
	}

	public function all() : array
	{
		return $this->items;
	}

	public function clear()
	{
		$this->items = [];

		return $this;
	}

	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	public function offsetGet($key)
	{
		return $this->get($key);
	}

	public function offsetExists($key)
	{
		return $this->has($key);
	}

	public function offsetUnset($key)
	{
		return $this->delete($key);
	}

	public function getIterator() : Iterator
	{
		return new ArrayIterator($this->items);
	}
}