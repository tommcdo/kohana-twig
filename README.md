koseven-twig
============

Version 1.0.7

[![Build Status](https://travis-ci.org/errotan/koseven-twig.svg?branch=master)](https://travis-ci.org/errotan/koseven-twig)

Koseven-twig is a [Koseven][1] module for the popular [Twig][2] template
engine. It was designed to offer the full capabilities of Twig with a strong
focus on operating within the guidelines and best practices of the Koseven
framework. This module provides a way to use Twigs exactly as Koseven [Views][3]
are used, and it uses a custom Twig Loader to locate Twig template files in the
[Cascading Filesystem][4].

Installation
------------

First, download this module to your modules directory:

	modules/twig

Then, add the twig package to your composer.json requirements:

	"twig/twig": "^2.0"

Then, install it using composer

	php composer.phar update

Then, enable the module in `APPPATH/bootstrap.php` by adding it to the modules
initialization:

	Kohana::modules([
		// ... all your other modules ...
		'twig' => MODPATH.'twig', // Twig templating engine
	]);

Also enable composer autoloader (vendor/autoload.php) in this file if not
already done so.

Usage
-----

Use Twigs just as you use would use Koseven Views. By default, your Twig files
go into the `views` directory anywhere in the cascading filesystem, and have
a `.html.twig` extension. (Both of these settings can be configured.) For
example, suppose you have a Twig file at `APPPATH/views/main.html.twig`, with
contents:

	<p>Hello, {{ name }}!</p>

Inside your action, you would attach the Twig as follows:

	$twig = Twig::factory('main');
	$twig->name = 'Tom';
	$this->response->body($twig);

Your Twig files can also reference other templates by name, which will be
located using the cascading filesystem. Note that the extension of the twig
file is omitted; in the following Twig template example, a file called
`template.html.twig` would be located in the cascading filesystem:

	{% extends "template" %}

For more information on Twig templates, see [Twig for Template Designers][5]

Configuration
-------------

Default configuration is kept in `MODPATH/koseven-twig/config/twig.php`. To
override it, you can create a config file at `APPPATH/config/twig.php` (or in
the `config/` directory of any module that gets loaded before this one) that
specifies values to any options you'd like to change.

Extending
---------

Twig offers many ways to extend the base templating environment. In
koseven-twig, this can be achieved by overriding the static `Twig::env()`
method. To do so, you can define the class `APPPATH/classes/Twig.php` as
follows:

	class Twig extends Kohana_Twig {

		protected static function env()
		{
			// Instantiate the base Twig environment from parent class.
			$env = parent::env();

			// Customize as needed.
			$env->addExtension(new Twig_Extension_Example);
			// ... do more stuff if you'd like ...

			return $env;
		}

	} // End Twig

Contributing
------------

Contributions are always welcome and appreciated. Since this is a Koseven
module, the main thing I ask is that the code conforms to
[Koseven's Conventions and Style][6]. If you're not familiar with them,
please read them over thoroughly.

[1]: http://koseven.ga
[2]: https://twig.symfony.com/
[3]: https://docs.koseven.ga/guide/kohana/mvc/views
[4]: https://docs.koseven.ga/guide/kohana/files
[5]: https://twig.symfony.com/doc/2.x/templates.html
[6]: https://docs.koseven.ga/guide/kohana/conventions
[7]: https://github.com/errotan/koseven-twig
