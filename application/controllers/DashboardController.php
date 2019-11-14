<?php

class DashboardController extends Controller {

	function __construct($controller, $action) {
	
		parent::__construct($controller, $action);
	}

	function index($arg=false) {

		$this->render = 0;

		echo '<pre>---';
		print_r($arg);
		echo '----<pre>';

		echo '<pre>---';
		print_r($_SERVER);
		echo '----<pre>';

		// $this->setGlobal('a', 'testsadfasdfasdf');


	}

	function test2($arg=false){

		echo 'Test2';
		echo '<pre>';
		print_r($arg);
		echo '<pre>';

		// $this->render = 0;

		// echo $this->getGlobal('a');
	}
}