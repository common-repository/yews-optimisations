<?php
/**
 * Plugin Name: YEWS Optimisations
 * Plugin URI: https://yews.com.au
 * Description: YEWS Optimisations for the websites that are using the Modernize, Flawless and Total Business themes from Goodlayers.
 * Version: 4.6.2.2
 * Author: Grigory Metlenko
 * Author URI: http://google.com/+GrigoryMetlenko
 * License: GPL2
*/

require_once(dirname(__FILE__).'/include/yews/custom-options.php');
require_once(dirname(__FILE__).'/include/yews/custom-checks.php');
require_once(dirname(__FILE__).'/include/yews/custom-login.php');
require_once(dirname(__FILE__).'/include/yews/custom-footer.php');
require_once(dirname(__FILE__).'/include/yews/custom-enquiries.php');
require_once(dirname(__FILE__).'/include/yews/custom-micro-structured-data.php');
require_once(dirname(__FILE__).'/include/yews/custom-yews-page.php');


register_activation_hook( __FILE__, 'yews_daily_checks_activation' );
register_deactivation_hook( __FILE__, 'yews_daily_checks_deactivation'); 


?>