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

        $cache = $this->cache_instance();

        if ( $cache )
        {
            $this->paths = $cache->get($this->_paths_cache_key);
        }

        if ( ! $this->paths )
        {
        }

        if ( $cache )
        {
            $cache->set($this->_paths_cache_key, $this->paths);
        }

        $this->add_paths();
    }

    /**
     * Returns an object, providing access to caching functionality
     * If you are using another cache module, override this method in Twig_Loader_CFS
     * @return Cache|null
     */
    protected function cache_instance()
    {
        if ( ! $this->_config['cache'] )
            return NULL;

        if ( ! in_array('cache', Kohana::modules()) )
            return NULL;

        return Cache::instance();
    }

    /**
     * Adds Kohana::include_paths() to Twig Filesystem Loader
     * Supports namespaces (directory aliases starting with @)
     * More info about namespaces here http://twig.sensiolabs.org/doc/api.html
     */
    protected function add_paths()
    {
        $namespaces = $this->_config['namespaces'];

        // Iterate through Kohana include paths
        foreach ( Kohana::include_paths() as $kohana_path )
        {
            $base_path = $kohana_path.$this->_config['path'];

            // Ignore modules without Twig views
            if ( ! file_exists($base_path) )
                continue;

            $this->addPath($base_path);

            foreach ( $namespaces as $ns_name => $fs_alias )
            {
                $ns_path = $base_path.DIRECTORY_SEPARATOR.$fs_alias;

                // Ignore modules without Twig namespace directory
                if ( ! file_exists($ns_path) )
                    continue;

                $this->addPath($ns_path, $ns_name);
            }
        }
    }

    protected function findTemplate($name)
    {
        // Add extension to files
        $name .= '.'.$this->_config['extension'];

        return parent::findTemplate($name);
    }

} // End CFS
