<?php namespace Rhine;

use Laravel\Asset;

class AssetManager
{
	/**
	 * Register and wire objects.
	 */
	public static function init()
	{
		// Twitter bootstrap
		Asset::add('bootstrap.css', 'css/bootstrap.min.css');
		Asset::add('bootstrap.js', 'js/bootstrap.min.js');
	}

}