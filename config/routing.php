<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/*
| -------------------------------------------------------------------
| Default Controler and Action
| -------------------------------------------------------------------
*/

	$config['controller']	= "dashboard";
	$config['action']		= 'index';

	$config['routingTable'] = array(
		'alpha' => 'dashboard@test2'
	);
