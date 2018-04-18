<?php

error_reporting(E_ALL);

define('SYSPATH', 'vendor/koseven/koseven/system/');
define('MODPATH', 'vendor/koseven/koseven/modules/');
define('APPPATH', getcwd().'/');
define('EXT', '.php');

require 'vendor/koseven/koseven/system/classes/Kohana/Core.php';
require 'vendor/koseven/koseven/system/classes/Kohana.php';

spl_autoload_register(['Kohana', 'auto_load']);

require 'vendor/autoload.php';
