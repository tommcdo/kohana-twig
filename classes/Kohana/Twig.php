<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Twig extends View {

	protected static $_env = NULL;

	public static function init()
	{
		require_once TWIGPATH.'vendor/twig/lib/Twig/Autoloader.php';
		Twig_Autoloader::register();

		$path = Kohana::$config->load('twig.cache');
		if ( ! is_writable($path))
		{
			throw new Kohana_Exception('Directory :dir must be writable', array(
				':dir' => Debug::path($path),
			));
		}
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		return new Twig($file, $data);
	}

	protected static function env()
	{
		if (static::$_env === NULL)
		{
			$config = Kohana::$config->load('twig');
			$loader = new Twig_Loader_CFS($config);
			static::$_env = new Twig_Environment($loader, $config->as_array());
		}
		return static::$_env;
	}

	function set_filename($file)
	{
		$this->_file = $file;
		return $this;
	}

	public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}
		$template = static::env()->loadTemplate($this->_file);
		return $template->render($this->_data);
	}

} // End Twig
