<?php

class LoadingTest extends PHPUnit_Framework_TestCase {

	public function testLoading()
	{
		$twig = new Twig;
		$this->assertTrue($twig instanceof Kohana_Twig);
	}
}
