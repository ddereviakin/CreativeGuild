<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');


/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * Set this to false if in production mode.
 *
 */

	if($_SERVER['SERVER_NAME'] == 'localhost') define ('DEVELOPMENT_ENVIRONMENT', true);
	else define ('DEVELOPMENT_ENVIRONMENT', false);




/*
 *---------------------------------------------------------------
 * 
 *---------------------------------------------------------------
 */
	date_default_timezone_set("America/Toronto");
	ini_set('memory_limit', '-1');
	set_time_limit(0);