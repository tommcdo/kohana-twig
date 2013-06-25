kohana-twig
===========

Kohana-twig is a [Kohana][1] 3.3 module for the popular [Twig][2] template
engine. It was designed to offer the full capabilities of Twig with a strong
focus on operating within the guidelines and best practices of the Kohana
framework. This module provides a way to use Twigs exactly as Kohana [Views][3]
are used, and it uses a custom Twig Loader to locate Twig template files in the
[Cascading Filesystem][4].

Installation
------------

First, clone this project from your `MODPATH/` directory:

	cd modules/
	git clone git://github.com/tommcdo/kohana-twig.git twig
	cd twig/
	git submodule init
	git submodule update

Then, enable the module in `APPPATH/bootstrap.php` by adding it to the modules
initialization:

	Kohana::modules(array(
		// ... all your other modules ...
		'twig'       => MODPATH.'twig',       // Twig templating engine
	));

This module was designed for Kohana 3.3, but can be easily made to work with
Kohana 3.2 by changing all filenames within the `classes/` directory to
lowercase.

Usage
-----

Use Twigs just as you use would use Kohana Views. By default, your Twig files
go into the `twigs` directory anywhere in the cascading filesystem, and have
a `.html` extension. (Both of these settings can be configured.) For example,
suppose you have a Twig file at `APPPATH/twigs/main.html`, with contents:

	<p>Hello, {{ name }}</p>

Inside your action, you would attach the Twig as follows:

	$twig = Twig::factory('main');
	$twig->name = 'Tom';
	$this->response->body($twig);

Your Twig files can also reference other templates by name, which will be
located using the cascading filesystem. Note that the extension of the twig
file is omitted; in the following Twig template example, a file called
`template.html` would be located in the cascading filesystem:

	{% extends "template" %}

For more information on Twig templates, see [Twig for Template Designers][5]

Configuration
-------------

Default configuration is kept in `MODPATH/twig/config/twig.php`. To override
it, you can create a config file at `APPPATH/config/twig.php` (or in the
`config/` directory of any module that gets loaded before this one) that
specifies values to any options you'd like to change.

Extending
---------

Twig offers many ways to extend the base templating environment. In
kohana-twig, this can be achieved by overriding the static `Twig::env()`
function.  To do so, you can define the class `APPPATH/classes/Twig.php` as
follows:

	class Twig extends Kohana_Twig {

		protected static function env()
		{
			// Instantiate the base Twig environment from parent class.
			$env = parent::env();

			// Customize as needed.
			$env->addExtension(new Twig_Extension_Example());
			// ... do more stuff if you'd like ...

			return $env;
		}

	} // End Twig

[1]: http://kohanaframework.org
[2]: http://twig.sensiolabs.org
[3]: http://kohanaframework.org/3.3/guide/kohana/mvc/views
[4]: http://kohanaframework.org/3.3/guide/kohana/files
[5]: http://twig.sensiolabs.org/doc/templates.html
