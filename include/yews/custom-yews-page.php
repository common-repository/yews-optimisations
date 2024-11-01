<?php
//[yews-optimisations]
function yews_optimisations_shortcode($atts){
	$yos_html = '';
	if ( is_user_logged_in() ) {
		if (current_user_can('edit_users')) {
			$current_user = wp_get_current_user();
			$yews_username = $current_user->user_login;
			$yews_userID = $current_user->ID;
			$yos_html .= '<div id="yos_menu" class="donotprint"><ul>';
			$yos_html .= '<li><a href="/yews/">Start</a></li>';
			$yos_html = apply_filters('yews_menu_item',$yos_html);
			$yos_html .= '</ul>';
			$yos_html .= '<style>				
				#yos_menu {background: #555;display: block;} 
				#yos_menu ul {margin-left: 0;} 
				#yos_menu ul li {display: inline-block;border-left: 1px solid #aaa;border-right: 1px solid #aaa;} 
				#yos_menu ul li a {color: #eee;display:block;padding: 5px 15px;}
				#yos_menu ul li a:hover {background: #888;}';
			$yos_html .= '</style></div>';
			if ($_GET['yos_s'] == '') {
				$yos_html .= '<h4>YEWS Optimisations</h4>';
				$yos_html = apply_filters('yews_start',$yos_html);
			}
			//Other pages
			$yos_s = $_GET['yos_s'];
			$yos_html = apply_filters('yews_menu_pages',$yos_html);
		}
		else {$yos_html = '<h4>You do not have enough permissions to view this page.</h4><p>Please contact the owner or webmaster if this is a mistake.</p>';}
			
	} else {
		$yos_html = '<div style="max-width: 400px;margin: 0 auto"><h4>Please login to view page</h4>';
		ob_start();
		wp_login_form(array( 'redirect' => site_url('/yews/')));
		$yos_html .= ob_get_clean();
		$yos_html .= '</div><style>input[type="password"] {padding: 19px 15px!important;width: 100%;max-width: 100%;}</style>';
	}
	return $yos_html;
}
add_shortcode( 'yews-optimisations', 'yews_optimisations_shortcode' );

add_action( 'init', function () {
	/* To be deactivated once YEWS Page fully depracated
	// Retrieve YEWS Settings
	$yews_settings = get_option('yews_settings');
	// Check if hosted with YEWS - if Yes, no need for YEWS Page, since using new Plugin
	if ($yews_settings['yews_hosted_by_yews'] != 1) {return;}
	*/
	
	$yews_page = get_page_by_path('yews');
	$yews_page_id = $yews_page->ID;
	$yews_page_status = $yews_page->post_status;
	if ($yews_page_id) {
		if ($yews_page_status != 'publish') {wp_publish_post($yews_page_id);}
		return;
	}
	else{
		$current_user = wp_get_current_user();
		$yews_username = $current_user->user_login;
		$yews_userID = $current_user->ID;
		$yews_page = array(
		  'post_content'   => '[yews-optimisations]',
		  'post_name'      => 'yews',
		  'post_title'     => 'YEWS',
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'post_author' => $yews_userID
		);
		wp_insert_post($yews_page);
		return;
	}
} );

add_action( 'admin_menu', 'yews_add_admin_menu' );
add_action( 'admin_init', 'yews_settings_init' );


function yews_add_admin_menu(  ) { 

	add_menu_page( 'YEWS Optimisations', 'YEWS', 'yews-admin', 'yews-optimisations', 'yews_options_page', 'dashicons-dashboard', 3 );
	add_submenu_page( 'yews-optimisations', 'YEWS Setup', 'Setup', 'yews-admin', 'yews-optimisations');
	add_submenu_page( 'yews-optimisations', 'YEWS Codes', 'Codes', 'yews-admin', 'yews-optimisations-codes', 'yews_options_page_codes');
	add_submenu_page( 'yews-optimisations', 'YEWS SEO', 'SEO', 'yews-admin', 'yews-optimisations-seo', 'yews_options_page_seo');
	add_submenu_page( 'yews-optimisations', 'YEWS Checks', 'Checks', 'yews-admin', 'yews-optimisations-checks', 'yews_options_page_checks');
}


function yews_settings_init(  ) { 

	register_setting( 'yewsPage', 'yews_settings' );
	register_setting('yewsCodes', 'yews_codes' );
	register_setting('yewsSeo', 'yews_seo' );
	register_setting('yewsChecks', 'yews_checks' );

	add_settings_section(
		'yews_yewsPage_setup', 
		__( 'Setup', 'wordpress' ), 
		'yews_settings_setup_callback', 
		'yewsPage'
	);
	
	add_settings_section(
		'yews_yewsPage_codes', 
		__( 'YEWS Codes', 'wordpress' ), 
		'yews_settings_codes_callback', 
		'yewsCodes'
	);
	
	add_settings_section(
		'yews_yewsPage_seo', 
		__( 'YEWS SEO', 'wordpress' ), 
		'yews_settings_seo_callback', 
		'yewsSeo'
	);
	
	add_settings_section(
		'yews_yewsPage_checks', 
		__( 'YEWS Checks', 'wordpress' ), 
		'yews_settings_checks_callback', 
		'yewsChecks'
	);

	add_settings_field( 
		'yews_hosted_by_yews', 
		__( 'Is this website hosted by YEWS?', 'wordpress' ), 
		'yews_hosted_by_yews_render', 
		'yewsPage', 
		'yews_yewsPage_setup' 
	);

	add_settings_field( 
		'yews_is_live', 
		__( 'Is this website live?', 'wordpress' ), 
		'yews_is_live_render', 
		'yewsPage', 
		'yews_yewsPage_setup' 
	);

	add_settings_field( 
		'yews_hosting_package', 
		__( 'YEWS Hosting Package:', 'wordpress' ), 
		'yews_hosting_package_render', 
		'yewsPage', 
		'yews_yewsPage_setup' 
	);
	
	add_settings_field( 
		'yews_analytics_code', 
		__( 'YEWS Google Analytics:', 'wordpress' ), 
		'yews_analytics_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);
	
	add_settings_field( 
		'yews_phone_code', 
		__( 'YEWS Phone Tracking Code:', 'wordpress' ), 
		'yews_phone_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);
	
	add_settings_field( 
		'yews_phoneno_code', 
		__( 'YEWS Phone Number:', 'wordpress' ), 
		'yews_phoneno_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);
	
	add_settings_field( 
		'yews_remarketing_code', 
		__( 'YEWS AdWords Remarketing Code:', 'wordpress' ), 
		'yews_remarketing_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);
	
	add_settings_field( 
		'yews_conversion_tracking_code', 
		__( 'YEWS Conversion Tracking Code:', 'wordpress' ), 
		'yews_conversion_tracking_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);
	
	add_settings_field( 
		'yews_conversion_tracking_pages_code', 
		__( 'YEWS Conversion Tracking Page IDs (Example: x,x,x):', 'wordpress' ), 
		'yews_conversion_tracking_pages_code_render', 
		'yewsCodes', 
		'yews_yewsPage_codes' 
	);


}


function yews_hosted_by_yews_render(  ) { 

	$options = get_option( 'yews_settings' );
	?>
	<input type='checkbox' name='yews_settings[yews_hosted_by_yews]' <?php checked( $options['yews_hosted_by_yews'], 1 ); ?> value='1'>
	<?php echo 'Hostname: '.gethostname();

}


function yews_is_live_render(  ) { 

	$options = get_option( 'yews_settings' );
	?>
	<input type='checkbox' name='yews_settings[yews_is_live]' <?php checked( $options['yews_is_live'], 1 ); ?> value='1'>
	<?php
}


function yews_hosting_package_render(  ) { 

	$options = get_option( 'yews_settings' );
	?>
	<select name='yews_settings[yews_hosting_package]'>
		<option value='1' <?php selected( $options['yews_hosting_package'], 1 ); ?>>None</option>
		<option value='2' <?php selected( $options['yews_hosting_package'], 2 ); ?>>Standard</option>
		<option value='3' <?php selected( $options['yews_hosting_package'], 3 ); ?>>Managed</option>
		<option value='4' <?php selected( $options['yews_hosting_package'], 4 ); ?>>Managed Plus</option>
		<option value='5' <?php selected( $options['yews_hosting_package'], 5 ); ?>>Managed Business</option>
	</select>

<?php

}

function yews_analytics_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	$yews_analytics_code = $options['yews_analytics_code'];
	$yews_analytics_code_old = get_option('yews_analytics_code');
	$yews_analytics_code = preg_replace('~\R~u', "\r\n", $yews_analytics_code );
	$yews_analytics_code_old = preg_replace('~\R~u', "\r\n", $yews_analytics_code_old );
	if ($yews_analytics_code === $yews_analytics_code_old) {
		if (!empty($yews_analytics_code_old)) {update_option("yews_analytics_code",'');}
		$yews_analytics_code_old = '';
	}
	?>
	<textarea cols='40' rows='5' name='yews_codes[yews_analytics_code]' style="min-width: 450px;max-width: 100%;"><?php echo $yews_analytics_code.$yews_analytics_code_old; ?></textarea>
	<?php
	$yews_analytics_code_old = get_option('yews_analytics_code');
	if (!empty($yews_analytics_code_old)) {echo '<br /><span style="color: #F00;font-weight: bold;">NOTE: settings need to be saved!</span>';}
}

function yews_phone_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	$yews_phone_code = $options['yews_phone_code'];
	$yews_phone_code_old = get_option('yews_phone_code');
	$yews_phone_code = preg_replace('~\R~u', "\r\n", $yews_phone_code );
	$yews_phone_code_old = preg_replace('~\R~u', "\r\n", $yews_phone_code_old );
	if ($yews_phone_code == $yews_phone_code_old) {
		if (!empty($yews_phone_code_old)) {update_option("yews_phone_code",'');}
		$yews_phone_code_old = '';
	}
	?>
	<textarea cols='40' rows='5' name='yews_codes[yews_phone_code]' style="min-width: 450px;max-width: 100%;"><?php echo $yews_phone_code.$yews_phone_code_old; ?></textarea>
	<?php
	$yews_phone_code_old = get_option('yews_phone_code');
	if (!empty($yews_phone_code_old )) {echo '<br /><span style="color: #F00;font-weight: bold;">NOTE: settings need to be saved!</span>';}
}

function yews_phoneno_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	$yews_phoneno_code = $options['yews_phoneno_code'];
	$yews_phoneno_code_old = get_option('yews_phoneno_code');
	$yews_phoneno_code = preg_replace('~\R~u', "", $yews_phoneno_code );
	$yews_phoneno_code_old = preg_replace('~\R~u', "", $yews_phoneno_code_old );
	if ($yews_phoneno_code == $yews_phoneno_code_old) {
		if (!empty($yews_phoneno_code_old)) {update_option("yews_phoneno_code",'');}
		$yews_phoneno_code_old = '';
	}	
	?>
	<input type='text' name='yews_codes[yews_phoneno_code]' value='<?php echo $yews_phoneno_code.$yews_phoneno_code_old; ?>'>
	<?php
	$yews_phoneno_code_old = get_option('yews_phoneno_code');
	if (!empty($yews_phoneno_code_old)) {echo '<br /><span style="color: #F00;font-weight: bold;">NOTE: settings need to be saved!</span>';}
}

function yews_remarketing_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	$yews_remarketing_code = $options['yews_remarketing_code'];
	$yews_remarketing_code_old = get_option('yews_remarketing_code');
	$yews_remarketing_code = preg_replace('~\R~u', "\r\n", $yews_remarketing_code );
	$yews_remarketing_code_old = preg_replace('~\R~u', "\r\n", $yews_remarketing_code_old );
	if ($yews_remarketing_code == $yews_remarketing_code_old) {
		if (!empty($yews_remarketing_code_old)) {update_option("yews_remarketing_code",'');}
		$yews_remarketing_code_old = '';
	}
	?>
	<textarea cols='40' rows='5' name='yews_codes[yews_remarketing_code]' style="min-width: 450px;max-width: 100%;"><?php echo $yews_remarketing_code.$yews_remarketing_code_old; ?></textarea>
	<?php
	$yews_remarketing_code_old = get_option('yews_remarketing_code');
	if (!empty($yews_remarketing_code_old)) {echo '<br /><span style="color: #F00;font-weight: bold;">NOTE: settings need to be saved or old code deleted!</span>';}
}

function yews_conversion_tracking_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	?>
	<textarea cols='40' rows='5' name='yews_codes[yews_conversion_tracking_code]' style="min-width: 450px;max-width: 100%;"><?php echo $options['yews_conversion_tracking_code']; ?></textarea>
	<?php
}

function yews_conversion_tracking_pages_code_render(  ) { 

	$options = get_option( 'yews_codes' );
	?>
	<input type='text' name='yews_codes[yews_conversion_tracking_pages_code]' value='<?php echo $options['yews_conversion_tracking_pages_code']; ?>'>
	<?php
}

function yews_settings_setup_callback(  ) { 

	echo __( 'Please keep this section up to date!', 'wordpress' );

}

function yews_settings_codes_callback(  ) { 

	echo __( 'Insert codes controlled by YEWS', 'wordpress' );

}

function yews_settings_seo_callback(  ) { 

	echo __( 'Settings for SEO - COMING SOON', 'wordpress' );

}

function yews_settings_checks_callback(  ) { 

	echo __( 'COMING SOON', 'wordpress' );

}


function yews_options_page(  ) { 
	if (!current_user_can('yews-admin')) {
		echo "Nothing to see here....";
		return;
	}
	?>
	<form action='options.php' method='post'>

		<h2>YEWS Optimisations</h2>

		<?php
		settings_fields( 'yewsPage' );
		do_settings_sections( 'yewsPage' );
		submit_button();
		?>

	</form>
	<?php

}

function yews_options_page_codes(  ) { 
	if (!current_user_can('yews-admin')) {
		echo "Nothing to see here....";
		return;
	}
	?>
	<form action='options.php' method='post'>
	
		<?php
		settings_fields( 'yewsCodes' );
		do_settings_sections( 'yewsCodes' );
		submit_button();
		?>

	</form>
	<?php

}

function yews_options_page_seo(  ) { 
	if (!current_user_can('yews-admin')) {
		echo "Nothing to see here....";
		return;
	}
	?>
	
	<form action='options.php' method='post'>
	
		<?php
		settings_fields( 'yewsSeo' );
		do_settings_sections( 'yewsSeo' );
		?> - <a target="_blank" href="/yews/?yos_s=msd">Settings are currently here...</a><?php 
		/*submit_button();*/
		?>

	</form>
	<?php

}

function yews_options_page_checks(  ) { 
	if (!current_user_can('yews-admin')) {
		echo "Nothing to see here....";
		return;
	}
	?>
	<h3>YEWS Checks</h3>
	<a target="_blank" href="/yews/?yos_s=checks">Checks are currently here...</a>
	<form action='options.php' method='post'>
	
		<?php /*
		settings_fields( 'yewsChecks' );
		do_settings_sections( 'yewsChecks' );
		submit_button();*/
		?>

	</form>
	<?php

}

?>