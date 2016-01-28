<?php

namespace WallaceMaxters\SevenFramework\Session;

interface SessionInterface
{

	public function all(): array;

	public function delete(string $name);

	public function get(string $name);

	public function has(string $name):boolean;

	public function id() : string;

	public function regenerate();

	public function set(string $key, $value);
}