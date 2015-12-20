<?php

namespace WallaceMaxters\SevenFramework\Routing;

/**
 * 
 * @deprecated 
 * @todo remove in next version
 * */
interface RouteInterface
{

	public function getName(): string;

	public function getPattern(): string;

	public function setName(string $name);
	
	public function setPattern(string $pattern);
}