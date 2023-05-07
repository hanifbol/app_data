<?php
function url($path) {
	$parsed_url = parse_url($_SERVER['PHP_SELF']);
	$path_array = explode('/', $parsed_url['path']);
	array_pop($path_array);
	return "/" . $path_array[1] . "/" . $path;
}