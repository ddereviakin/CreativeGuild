<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/**
 * View Class
 * 
 * @author stephen
 */
class View{

	protected $variables = array();		// all variable required for view
	protected $_controller;				// folder name
	protected $_action; 				// file name
	
	
	function __construct($controller,$action) {
		$this->_controller = $controller;
		$this->_action = $action;
	}
	
	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	function get($name){
		return $this->variables[$name];
	}
	
	function render($renderHeader = 1, $ctr_variables = false) {
		
		if($ctr_variables) foreach ($ctr_variables as $key => $value) $this->variables[$key] = $value;
		extract($this->variables);
		if($GLOBALS['_CUSTOM_VAR']) extract($GLOBALS['_CUSTOM_VAR']);
		
		if ($renderHeader == 1) {
			
			if (file_exists(BASEPATH . 'application/views/' . strtolower($this->_controller) . '/header.php'))
				include (BASEPATH . 'application/views/' . strtolower($this->_controller) . '/header.php');
			else
				include (BASEPATH . 'application/views/header.php');
		}

		if (file_exists(BASEPATH . 'application/views/' . strtolower($this->_controller) . '/' . strtolower($this->_action) . '.php'))
			include (BASEPATH . 'application/views/' . strtolower($this->_controller) . '/' . strtolower($this->_action) . '.php');
		else
			die('The file ' . BASEPATH . 'application/views/' . strtolower($this->_controller) . '/' . strtolower($this->_action) . '.php does not exist.');
		
		
		if ($renderHeader == 1) {
			
			if (file_exists(BASEPATH . 'application/views/' . strtolower($this->_controller) . '/footer.php'))
				include (BASEPATH . 'application/views/' . strtolower($this->_controller) . '/footer.php');
			else
				include (BASEPATH . 'application/views/footer.php');
		}
	}

}

