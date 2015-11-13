<?php

namespace WallaceMaxters\SevenFramework\Routing;

interface RouteInterface
{
	const PATTERN_TRANSLATION = array(
		'*'     => '(.*)',
		'{num}' => '(\d+)',
		'{str}' => '([a-z0-9-_]+)',
		'/'     => '\/',
		'\\'    => '\\\\'
	);

	public function setPattern(string $pattern);

	public function getPattern(): string;
}