<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig loader for Kohana's cascading filesystem
 */
class Twig_Loader_CFS extends Twig_Loader_Filesystem {

    protected $_paths_cache_key = 'twig_cfs_loader_paths';

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
        // No paths by default
        parent::__construct();

		$this->_config = $config;

        $cache = Cache::instance();

        $this->paths = $cache->get($this->_paths_cache_key);

        if ( ! $this->paths )
        {
            $this->add_kohana_paths();
            $cache->set($this->_paths_cache_key, $this->paths);
        }
	}

    /**
     * Adds Kohana::include_paths() to Twig Filesystem Loader
     * Supports namespaces (directory aliases starting with @)
     * More info about namespaces here http://twig.sensiolabs.org/doc/api.html
     */
    protected function add_kohana_paths()
    {
        $namespaces = $this->_config['namespaces'];

        // Iterate through Kohana paths first
        // So namespaces from top-level directories will overwrite low-level directories
        foreach ( Kohana::include_paths() as $kohana_path )
        {
            $base_path = $kohana_path.$this->_config['path'];

            $this->addPath($base_path);

            foreach ( $namespaces as $ns_name => $fs_alias )
            {
                $this->addPath($base_path.DIRECTORY_SEPARATOR.$fs_alias, $ns_name);
            }
        }
    }

    public function addPath($path, $namespace = self::MAIN_NAMESPACE)
    {
        // Ignore modules without Twig views
        if ( ! file_exists($path) OR ! is_dir($path) )
            return;

        parent::addPath($path, $namespace);
    }

    protected function findTemplate($name)
    {
        // Add extension to files
        $name .= '.'.$this->_config['extension'];

        return parent::findTemplate($name);
    }

} // End CFS
