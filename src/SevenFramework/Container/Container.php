<?php

class Container implements ArrayAccess
{
	protected $storage = [];

	protected $closures;

	public function set(string $name, \Closure $resolver)
	{
		$this->storage[$name] = $resolver->call($this);
	}

	public function get(string $name)
	{
		return $this->storage[$name];
	}

	public function has(string $name)
	{
		return isset($this->storage[$name]);
	}

	public function delete(string $name)
	{
		unset($this->storage[$name]);
	}
}