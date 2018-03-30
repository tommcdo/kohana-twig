<?php

use \Mockery as m;

class TwigTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		Kohana::$config = m::mock('Config')->makePartial()
		                                   ->attach(new Config_File);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testLoadingTwig()
	{
		$twig = new Twig;
		$this->assertTrue($twig instanceof Kohana_Twig);
	}

	public function testInit()
	{
		$status = Twig::init();
		$this->assertTrue($status);
	}

	public function testFactory()
	{
		$twig = Twig::factory();
		$this->assertTrue($twig instanceof Twig);
	}

	public function testRender()
	{
		Kohana::$config->shouldReceive('load')
		               ->with('twig')
		               ->once()
		               ->andReturn(Kohana::$config);
		Kohana::$config->shouldReceive('get')
		               ->with('loader')
		               ->once()
		               ->andReturn([
						'extension' => 'html',
						'path'      => '',
					   ]);
		Kohana::$config->shouldReceive('get')
		               ->with('environment')
		               ->once()
		               ->andReturn([
						'auto_reload'         => (Kohana::$environment == Kohana::DEVELOPMENT),
						'autoescape'          => TRUE,
						'base_template_class' => 'Twig_Template',
						'cache'               => APPPATH.'cache/twig',
						'charset'             => 'utf-8',
						'optimizations'       => -1,
						'strict_variables'    => FALSE,
					   ]);
		Kohana::$config->shouldReceive('get')
		               ->with('functions')
		               ->once()
		               ->andReturn([]);
		Kohana::$config->shouldReceive('get')
		               ->with('filters')
		               ->once()
		               ->andReturn([]);
		Kohana::$config->shouldReceive('get')
		               ->with('tests')
		               ->once()
		               ->andReturn([]);

		$twig = Twig::factory();
		$twig->hello = 'Hello World!';
		$view = $twig->render('tests/test');
		$this->assertEquals("Hello World!", trim($view));
	}
}
