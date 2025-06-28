<?php
use system\core\text\translit;

if (!function_exists('translit_slug')) {
	function translit_slug($value)
	{
		return translit::translit_slug($value);
	}
}

if (!function_exists('translit_path')) {
	function translit_path($value)
	{
		return translit::translit_path($value);
	}
}


if (!function_exists('traslit_url')) {
	function traslit_url($url)
	{
		return translit::traslit_url($url);
	}
}

if (!function_exists('translit_file')) {
	function translit_file($filename)
	{
		return translit::translit_file($filename);
	}
}
