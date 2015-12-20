<?php

namespace WallaceMaxters\Helpers;


function str_slug(string $string, string $separator = null)
{
	return preg_replace_callback('/([A-Z])/u', function ($matches) use($separator)
	{
		return $separator . strtolower($matches[1]);
	}, $string);
}



echo str_slug('testeCamelCaseÁt', '-');
