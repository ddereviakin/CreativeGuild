<?php

class FallbackController extends Controller {

	function __construct($controller, $action) {
	
		parent::__construct($controller, $action);

	}

	function index( $arg=array() ) {

		$this->render = 0;

		echo '<pre>---FallBack---';
		print_r($arg);
		echo '---<pre>';
		// echo $b;

		


		// $this->setVariable('test', 'Hello World');
		// $this->setVariable('a', 'Hello bbb');
		// $this->_view->set('yo', $this->session->get('aa'));
	}
}