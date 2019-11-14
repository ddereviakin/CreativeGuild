<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
/**
 * Bootstrap
 * 
 * Will direct all request to its specific conrtoller.
 */
	

/*
 *---------------------------------------------------------------
 * Define All other required Constants
 *---------------------------------------------------------------
 */

	$protocol = 'http';
	if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
	else  $protocol = !empty($_SERVER['HTTPS']) ? "https" : "http";

	$absolute_sub_folder =  str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
	$absolute_sub_folder =  str_replace('/index.php', "", $absolute_sub_folder);

	$sub_folder =  str_replace('/index.php', "", $_SERVER['PHP_SELF']);

	// Path to the root folder
	define('BASEPATH', $_SERVER['DOCUMENT_ROOT'].$absolute_sub_folder.'/');
	define('BASEPATH_ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
	
	// 'http://localhost/PHPFrameWork/'
	define('BASEURL',$protocol . '://'.$_SERVER['SERVER_NAME'].$sub_folder.'/');
	define('BASEURL_ROOT', $protocol . '://'.$_SERVER['SERVER_NAME']);


/*
 *---------------------------------------------------------------
 * User Config
 *---------------------------------------------------------------
 */
	require_once BASEPATH . 'config/config.php';


/*
 *---------------------------------------------------------------
 * Composer Autoload
 *---------------------------------------------------------------
 */
	require_once BASEPATH . 'vendor/autoload.php';


/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * If Envidoment variable is set to true.
 */
	if (DEVELOPMENT_ENVIRONMENT == true) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', BASEPATH. 'logs/error.log');
	}


/*
 *---------------------------------------------------------------
 * Gets the url
 *---------------------------------------------------------------
 */
	$url = '';
	if(isset($_GET['url'])){
		$url = $_GET['url'];
	}


/*
 *---------------------------------------------------------------
 * REMOVES MAGIC QUOTES
 *---------------------------------------------------------------
 *
 * Cleans the url
 */
	function stripSlashesDeep($value) {
		
		$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
		return $value;
	}
	
	
	function removeMagicQuotes() {
		
		if ( get_magic_quotes_gpc() ) {
			$_GET    = stripSlashesDeep($_GET   );
			$_POST   = stripSlashesDeep($_POST  );
			$_COOKIE = stripSlashesDeep($_COOKIE);
		}
	}
	
	
	function unregisterGlobals() {
		
		if (ini_get('register_globals')) {
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
		$GLOBALS['_CUSTOM_VAR'] = [];
	}


/*
 *---------------------------------------------------------------
 * Autoloading Classes
 *---------------------------------------------------------------
 *
 * Many developers writing object-oriented applications create one PHP source file per-class definition. 
 * One of the biggest annoyances is having to write a long list of needed includes at the beginning of each script (one for each class).
 * 
 * In PHP 5, this is no longer necessary. You may define an __autoload() function which is automatically called in 
 * case you are trying to use a class/interface which hasn't been defined yet. 
 * By calling this function the scripting engine is given a last chance to load the class before PHP fails with an error.
 * 
 * http://php.net/manual/en/language.oop5.autoload.php
 * 
 */
	function autoload_classes($name){
		
		if (file_exists(BASEPATH . 'system/' . $name . '.php'))
			require_once(BASEPATH . 'system/' . $name . '.php');
			
		else if (file_exists(BASEPATH . 'application/controllers/' . $name . '.php'))
			require_once(BASEPATH . 'application/controllers/' . $name . '.php');
			
		else if (file_exists(BASEPATH . 'application/helpers/' . $name . '.php'))
			require_once(BASEPATH . 'application/helpers/' . $name . '.php');

		else if (file_exists(BASEPATH . 'application/models/' . $name . '.php'))
			require_once(BASEPATH . 'application/models/' . $name . '.php');

		else if (file_exists(BASEPATH . 'application/library/' . $name . '.php'))
			require_once(BASEPATH . 'application/library/' . $name . '.php');
			
		else {
			echo $name,' Class Not Found';
			exit;
		}
	}

	spl_autoload_register('autoload_classes');


/**
 *---------------------------------------------------------------
 * Load a config file
 *---------------------------------------------------------------
 */
	function load_config($name) {
		
		$configuration = array();
		
		if (!file_exists(BASEPATH . 'config/' . $name . '.php'))
			die('The file ' . BASEPATH . 'config/' . $name . '.php does not exist.');
	
		require(BASEPATH . 'config/' . $name . '.php');
			
		if (!isset($config) OR !is_array($config))
			die('The file ' . BASEPATH . 'config/' . $name . '.php file does not appear to be formatted correctly.');
				
		if (isset($config) AND is_array($config))
			$configuration = array_merge($configuration, $config);
		
		return $configuration;
	}


/**
 *---------------------------------------------------------------
 * Loads a view file
 *---------------------------------------------------------------
 */	
	function load_view($file_name, $var=false){

		if($GLOBALS['_CUSTOM_VAR']) extract($GLOBALS['_CUSTOM_VAR']);
		if($var) extract($var);

		if (file_exists(BASEPATH . 'application/views/' . $file_name . '.php'))
			include(BASEPATH . 'application/views/' . $file_name . '.php');

		else {
			echo $file_name,' View Class Not Found';
			exit;
		}
	}


/**
 *---------------------------------------------------------------
 * Loads a library file
 *---------------------------------------------------------------
 */	
	function load_lib($file_name, $var=false){

		if (file_exists(BASEPATH . 'application/library/' . $file_name . '.php'))
			require_once(BASEPATH . 'application/library/' . $file_name . '.php');

		else {
			echo $file_name,' View Class Not Found';
			exit;
		}
	}


/**
 *---------------------------------------------------------------
 * Sets Global Variable
 *---------------------------------------------------------------
 */	
	function setGlobal($name,$value) {
		$GLOBALS['_CUSTOM_VAR'][$name] = $value;
	}


/**
 *---------------------------------------------------------------
 * Gets Global Variable
 *---------------------------------------------------------------
 */	
	function getGlobal($name){
		return $GLOBALS['_CUSTOM_VAR'][$name];
	}


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 */
	removeMagicQuotes();
	unregisterGlobals();

	$config = load_config('routing');
	$urlArray = array();

	if (!isset($url) || $url==''){
		$controller = $config['controller'];	// decrared in routing.php in config
		$action 	= $config['action'];
	}
	else{
		$urlArray = explode("/", strtolower($url));
		
		if(file_exists(BASEPATH . 'application/controllers/' . ucfirst($urlArray[0]).'Controller.php')){
			$controller = $urlArray[0];
			array_shift($urlArray);
		}
		else{
			$controller = 'Fallback';
			$action = 'index';
		}

		if(isset($urlArray[0])){
			$action = $urlArray[0];

			if ((int)method_exists(ucfirst($controller).'Controller', $action)) array_shift($urlArray);
			else $action = 'index';
		}
		else{
			$action = 'index';
		}
	}

	if(isset($config['routingTable']) && count($config['routingTable'])>0){
		$routingTable = $config['routingTable'];

		if(isset($urlArray[0]) && isset($routingTable[$urlArray[0]])){
			$tmp = explode("@",$routingTable[$urlArray[0]]);
			$controller = $tmp[0];
			$action = $tmp[1];
			array_shift($urlArray);
		}
	}

	if(file_exists(BASEPATH . 'application/helpers/_g.php')){
		$_gc = new _g($controller,$action);
	}

	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action);

	if ((int)method_exists($controllerName, $action)){
		call_user_func_array(array($dispatch,$action),array($urlArray));
	}
	else{
		echo "$action can not be found in $controllerName";
		exit;
	}










