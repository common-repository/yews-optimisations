<?php

function yews_checks() {
	$yews_checks = array();
	$blog_url = get_bloginfo('url');
	
	// Retrieve Server / WP settings
	$yews_server_constants = @get_defined_constants();
	
	// Checking if Website is discouraging search engines
	if (get_option('blog_public')) {}
	else {$yews_checks[] = 'Discouraging Search Engines';}
	
	// Checking if Google Analytics Code is added	
	$yewsAnalytics = get_option("yews_codes");
	$yews_analytics_code = $yewsAnalytics['yews_analytics_code'];

	if (empty($yews_analytics_code)) {
		$yewsAnalyticsCode_old = get_option("yews_analytics_code");
		if (!empty($yewsAnalyticsCode_old)) {
	  		$yews_analytics_code = $yewsAnalyticsCode_old;
	  		$yews_settings = get_option('yews_settings');
			// Check if hosted with YEWS
			if ($yews_settings['yews_hosted_by_yews'] == 1) {$yews_checks[] = 'Need to migrate Google Analytics Code to <a href="'.$blog_url.'/wp-admin/admin.php?page=yews-optimisations-codes">YEWS Codes</a>';}
	 	}
	}
	if (empty($yews_analytics_code)) {$yews_checks[] = 'Need to add Google Analytics Code to <a href="'.$blog_url.'/wp-admin/admin.php?page=yews-optimisations-codes">Customize</a> > YEWS Codes';}
	
	//Checking if WordPress has enough memory allocated
	$yews_server_constant_wp_memory = substr($yews_server_constants['WP_MEMORY_LIMIT'], 0, -1);
	if ($yews_server_constant_wp_memory < 64) {$yews_checks[] = 'WP Memory Not enough - <a href="https://yews.com.au/resources/wordpress-memory-limits/">View Fix</a>';}
	$yews_server_constant_wp_max_memory = substr($yews_server_constants['WP_MAX_MEMORY_LIMIT'], 0, -1);
	if ($yews_server_constant_wp_max_memory < 256) {$yews_checks[] = 'WP Max Memory Not enough - <a href="https://yews.com.au/resources/wordpress-memory-limits/">View Fix</a>';}
	
	// Checking for up to date PHP Version
	if (version_compare(phpversion(), '5.5.0', '<')) {$yews_checks[] = 'Need to upgrade PHP version to at least 5.5, preferrably 5.6';}
	
	// Check if WP_CRON is disabled
	$yews_wp_cron = $yews_server_constants['DISABLE_WP_CRON'];
	if ($yews_wp_cron != 1) {$yews_checks[] = 'DISABLE_WP_CRON is not set to true - <a href="https://yews.com.au/resources/cron-job-wordpress/">View Fix</a>';}
	
	// return all the failed checks
	return $yews_checks;
}