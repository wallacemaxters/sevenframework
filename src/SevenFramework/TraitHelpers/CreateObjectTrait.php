<?php

namespace WallaceMaxters\SevenFramework\TraitHelpers;

trait CreateObjectTrait
{
	public static function create(... $arguments)
	{
		return new static(...$arguments);
	}
}