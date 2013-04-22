<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig loader for Kohana's cascading filesystem
 */
class Twig_Loader_CFS implements Twig_LoaderInterface {

	protected $_config;

	public function __construct($config)
	{
		$this->_config = $config;
	}

	public function find_template($name)
	{
		if (($path = Kohana::find_file($this->_config['path'], $name, $this->_config['extension'])) === FALSE)
		{
			throw new Twig_Exception('The requested twig :name could not be found', array(
				':name' => $name,
			));
		}
		return $path;
	}

	public function getSource($name)
	{
		return file_get_contents($this->find_template($name));
	}

	public function getCacheKey($name)
	{
		return $this->find_template($name);
	}

	public function isFresh($name, $time)
	{
        return filemtime($this->find_template($name)) <= $time;
	}

} // End CFS
