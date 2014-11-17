<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig loader for Kohana's cascading filesystem
 */
class Twig_Loader_CFS implements Twig_LoaderInterface {

	/**
	 * Loader configuration
	 */
	protected $_config;

	/**
	 * Constructor
	 *
	 * @param  array  $config  Loader configuration
	 */
	public function __construct($config)
	{
		$this->_config = $config;
	}

	/**
	 * Find a template file in the cascading filesystem
	 *
	 * @param   string  $name  Base name of template file
	 * @return  string  Path to template file
	 */
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

	/**
	 * Get the contents of template
	 *
	 * @param   string  $name  Base name of template
	 * @return  string  Contents of template
	 */
	public function getSource($name)
	{
		return file_get_contents($this->find_template($name));
	}

	/**
	 * Get the cache key of template
	 *
	 * @param   string  $name  Base name of template
	 * @return  string  Cache key of template
	 */
	public function getCacheKey($name)
	{
		return $name;
	}

	/**
	 * Determine if compiled template is fresh
	 *
	 * @param   string  $name  Base name of template
	 * @param   int     $time  Timestamp to compare against
	 * @return  bool    TRUE iff compiled template is older than timestamp
	 */
	public function isFresh($name, $time)
	{
        return filemtime($this->find_template($name)) <= $time;
	}

} // End CFS
