<?php

namespace WallaceMaxters\SevenFramework\Routing;

/**
 * 
 * @deprecated 
 * @todo remove in next version
 * */
interface RouteInterface
{

	public function setPattern(string $pattern);

	public function getPattern(): string;
}