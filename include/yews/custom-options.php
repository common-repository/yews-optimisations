<?php 
if ( ! function_exists( 'yews_customize_register' ) ) {
	function yews_customize_register($wp_customize) 
	{
	
		$wp_customize->add_section("yewssiteoptions", array(
			"title" => __("YEWS Site Options", "customizer_yewssiteoptions_sections"),
			"priority" => 20,
		));
		
		$wp_customize->add_setting("yews_footer_credits", array(
			"type" => 'option',
			'capability' => 'yews-admin',
			"default" => '<a href="https://yews.com.au/small-business-web-design">Web Design</a> by YEWS',
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_footer_credits",
			array(
				"label" => __("Footer Credits", "customizer_yews_footercredits_code_label"),
				"section" => "yewssiteoptions",
				"settings" => "yews_footer_credits",
			)
		));
		
		$wp_customize->add_section("yewscodes", array(
			"title" => __("YEWS Codes (deprecated)", "customizer_yewscodes_sections"),
			"priority" => 30,
		));
		
		if (get_theme_mod("yews_analytics_code")) {$yewsAnalyticsCode = get_theme_mod("yews_analytics_code");wp_cache_delete( 'alloptions', 'options' );remove_theme_mod("yews_analytics_code");}
		else {$yewsAnalyticsCode = '';}
		
		if (!empty(get_option('yews_analytics_code'))) {
			$wp_customize->add_setting("yews_analytics_code", array(
				"type" => 'option',
				'capability' => 'yews-admin',
				"default" => $yewsAnalyticsCode,
				"transport" => "refresh",
			));
			
			if (!empty($yewsAnalyticsCode)) {update_option("yews_analytics_code",$yewsAnalyticsCode);}
			
			
			$wp_customize->add_control(new WP_Customize_Control(
				$wp_customize,
				"yews_analytics_code",
				array(
					"label" => __("Enter Analytics Code", "customizer_yews_analytics_code_label"),
					"section" => "yewscodes",
					"settings" => "yews_analytics_code",
					"type" => "textarea",
				)
			));
		}
		
		if (get_theme_mod("yews_phone_code")) {$yewsPhoneCode= get_theme_mod("yews_phone_code");wp_cache_delete( 'alloptions', 'options' );remove_theme_mod("yews_phone_code");}
		else {$yewsPhoneCode= '';}
		
		if (!empty(get_option('yews_phone_code'))) {
			$wp_customize->add_setting("yews_phone_code", array(
				"type" => "option",
				"capability" => 'yews-admin',
				"default" => $yewsPhoneCode,
				"transport" => "refresh",
			));
			if (!empty($yewsPhoneCode)) {update_option("yews_phone_code",$yewsPhoneCode);}
			
			$wp_customize->add_control(new WP_Customize_Control(
				$wp_customize,
				"yews_phone_code",
				array(
					"label" => __("Enter Phone Tracking Code", "customizer_yews_phone_code_label"),
					"section" => "yewscodes",
					"settings" => "yews_phone_code",
					"type" => "textarea",
				)
			));
		}
		
		if (get_theme_mod("yews_phoneno_code")) {$yewsPhoneNoCode= get_theme_mod("yews_phoneno_code");wp_cache_delete( 'alloptions', 'options' );remove_theme_mod("yews_phoneno_code");}
		else {$yewsPhoneNoCode= '';}
		
		if (!empty(get_option('yews_phoneno_code'))) {
			$wp_customize->add_setting("yews_phoneno_code", array(
				"type" => "option",
				"capability" => 'yews-admin',
				"default" => $yewsPhoneNoCode,
				"transport" => "refresh",
			));
			if (!empty($yewsPhoneNoCode)) {update_option("yews_phoneno_code",$yewsPhoneNoCode);}
			
			$wp_customize->add_control(new WP_Customize_Control(
				$wp_customize,
				"yews_phoneno_code",
				array(
					"label" => __("Enter Phone Number", "customizer_yews_phoneno_code_label"),
					"section" => "yewscodes",
					"settings" => "yews_phoneno_code",
				)
			));
		}
		
		if (get_theme_mod("yews_remarketing_code")) {$yewsRemarketingCode= get_theme_mod("yews_remarketing_code");wp_cache_delete( 'alloptions', 'options' );remove_theme_mod("yews_remarketing_code");}
		else {$yewsRemarketingCode= '';}
		
		if (!empty(get_option('yews_remarketing_code'))) {
			$wp_customize->add_setting("yews_remarketing_code", array(
				"type" => "option",
				"capability" => 'yews-admin',
				"default" => $yewsRemarketingCode,
				"transport" => "refresh",
			));
			if (!empty($yewsRemarketingCode)) {update_option("yews_remarketing_code",$yewsRemarketingCode);}
			
			$wp_customize->add_control(new WP_Customize_Control(
				$wp_customize,
				"yews_remarketing_code",
				array(
					"label" => __("Enter AdWords Remarketing Code", "customizer_yews_remarketing_code_label"),
					"section" => "yewscodes",
					"settings" => "yews_remarketing_code",
					"type" => "textarea",
				)
			));
		}
		
		$wp_customize->add_section("yewshellobar", array(
			"title" => __("YEWS Hello bar", "customizer_yewshellobar_sections"),
			"priority" => 31,
		));
		
		$wp_customize->add_setting("yews_hellobartext_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_hellobartext_code",
			array(
				"label" => __("Hello Bar Text", "customizer_yews_hellobartext_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobartext_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarbuttontext_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_hellobarbuttontext_code",
			array(
				"label" => __("Hello Bar Button Text", "customizer_yews_hellobarbuttontext_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarbuttontext_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarbuttonurl_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_hellobarbuttonurl_code",
			array(
				"label" => __("Hello Bar Button URL", "customizer_yews_hellobarbuttonurl_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarbuttonurl_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarclasses_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_hellobarclasses_code",
			array(
				"label" => __("Hello Bar Classes", "customizer_yews_hellobarclasses_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarclasses_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarbgcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_hellobarbgcolor_code",
			array(
				"label" => __("Hello Bar BG Color", "customizer_yews_hellobarbgcolor_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarbgcolor_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobartextcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_hellobartextcolor_code",
			array(
				"label" => __("Hello Bar Text Color", "customizer_yews_hellobartextcolor_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobartextcolor_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarbuttonbgcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_hellobarbuttonbgcolor_code",
			array(
				"label" => __("Hello Bar Button BG Color", "customizer_yews_hellobarbuttonbgcolor_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarbuttonbgcolor_code",
			)
		));
		
		$wp_customize->add_setting("yews_hellobarbuttontextcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_hellobarbuttontextcolor_code",
			array(
				"label" => __("Hello Bar Button Text Color", "customizer_yews_hellobarbuttontextcolor_code_label"),
				"section" => "yewshellobar",
				"settings" => "yews_hellobarbuttontextcolor_code",
			)
		));
		
		// BOTTOM BAR
		
		$wp_customize->add_section("yewsbottombar", array(
			"title" => __("YEWS Bottom bar", "customizer_yewsbottombar_sections"),
			"priority" => 32,
		));
		
		$wp_customize->add_setting("yews_bottombar_enabled", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombar_enabled",
			array(
				"label" => __("Enable Bottom Bar", "customizer_yews_bottombar_enabled_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombar_enabled",
				"type" => "checkbox"
			)
		));
		
		
		$wp_customize->add_setting("yews_bottombar_buttons", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombar_buttons",
			array(
				"label" => __("Number of Buttons", "customizer_yews_bottombar_buttons_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombar_buttons",
				"type" => "select",
				"choices" => array("1" => 1, "2" => 2),
			)
		));
		
		$wp_customize->add_setting("yews_bottombar_bgcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_bottombar_bgcolor_code",
			array(
				"label" => __("Bottom Bar BG Color", "customizer_yews_bottombar_bgcolor_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombar_bgcolor_code",
			)
		));
		
		// BOTTOM BAR BUTTON 1
		
		$wp_customize->add_setting("yews_bottombarbutton_1_text_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_1_text_code",
			array(
				"label" => __("Bottom Bar Button 1 Text", "customizer_yews_bottombarbutton_1_text_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_1_text_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_1_url_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_1_url_code",
			array(
				"label" => __("Bottom Bar Button 1 URL", "customizer_yews_bottombarbutton_1_url_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_1_url_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_1_classes_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_1_classes_code",
			array(
				"label" => __("Bottom Bar Button 1 Classes", "customizer_yews_bottombarbutton_1_classes_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_1_classes_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_1_bgcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_bottombarbutton_1_bgcolor_code",
			array(
				"label" => __("Bottom Bar Button 1 BG Color", "customizer_yews_bottombarbutton_1_bgcolor_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_1_bgcolor_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_1_textcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_bottombarbutton_1_textcolor_code",
			array(
				"label" => __("Bottom Bar Button 1 Text Color", "customizer_yews_bottombarbutton_1_textcolor_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_1_textcolor_code",
			)
		));
		
		// BOTTOM BAR BUTTON 2
		
		$wp_customize->add_setting("yews_bottombarbutton_2_text_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_2_text_code",
			array(
				"label" => __("Bottom Bar Button 2 Text", "customizer_yews_bottombarbutton_2_text_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_2_text_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_2_url_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_2_url_code",
			array(
				"label" => __("Bottom Bar Button 2 URL", "customizer_yews_bottombarbutton_2_url_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_2_url_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_2_classes_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize,
			"yews_bottombarbutton_2_classes_code",
			array(
				"label" => __("Bottom Bar Button 2 Classes", "customizer_yews_bottombarbutton_2_classes_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_2_classes_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_2_bgcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_bottombarbutton_2_bgcolor_code",
			array(
				"label" => __("Bottom Bar Button 2 BG Color", "customizer_yews_bottombarbutton_2_bgcolor_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_2_bgcolor_code",
			)
		));
		
		$wp_customize->add_setting("yews_bottombarbutton_2_textcolor_code", array(
			"default" => "",
			"transport" => "refresh",
		));
		
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			"yews_bottombarbutton_2_textcolor_code",
			array(
				"label" => __("Bottom Bar Button 2 Text Color", "customizer_yews_bottombarbutton_2_textcolor_code_label"),
				"section" => "yewsbottombar",
				"settings" => "yews_bottombarbutton_2_textcolor_code",
			)
		));
		
	}


add_action("customize_register","yews_customize_register");
}
if ( ! function_exists( 'yews_add_analytics_code' ) ) {
	add_action('wp_head','yews_add_analytics_code');
	function yews_add_analytics_code() {
		$yewsAnalytics = get_option("yews_codes");
		$yewsAnalyticsCode = $yewsAnalytics['yews_analytics_code'];
		if (empty($yewsAnalyticsCode)) {
			$yewsAnalyticsCode_old = get_option("yews_analytics_code");
			if (!empty($yewsAnalyticsCode_old)) {
		  		$yewsAnalyticsCode = $yewsAnalyticsCode_old;
		 	}
		 	else {return;}
		}
		if (!empty($yewsAnalyticsCode)) $output="<!-- YEWS Google Analytics Code -->".$yewsAnalyticsCode;
		else {return;}
		echo $output;
	}
}

if ( ! function_exists( 'yews_add_phone_code' ) ) {
	add_action('wp_head','yews_add_phone_code');
	function yews_add_phone_code() {
		$yewsPhone = get_option("yews_codes");
		$yewsPhoneCode = $yewsPhone['yews_phone_code'];
		if (empty($yewsPhoneCode)) {
			$yewsPhoneCode_old = get_option("yews_phone_code");
			if (!empty($yewsPhoneCode_old)) {
		  		$yewsPhoneCode = $yewsPhoneCode_old;
		 	}
		 	else {return;}
		}
		
		$yewsPhoneNoCode = $yewsPhone['yews_phoneno_code'];
		if (empty($yewsPhoneNoCode)) {
			$yewsPhoneNoCode_old = get_option("yews_phoneno_code");
			if (!empty($yewsPhoneNoCode_old)) {
		  		$yewsPhoneNoCode = $yewsPhoneNoCode_old;
		 	}
		 	else{return;}
		}
		
		if ((!empty($yewsPhoneCode)) && (!empty($yewsPhoneNoCode))) $output="<!-- YEWS Phone Tracking Code -->".$yewsPhoneCode."<script type='text/javascript'>
			var callback = function(formatted_number, mobile_number) {
				var e = document.getElementById('number_link');
				e.href = 'tel:' + mobile_number;
				e.innerHTML = '';
				e.appendChild(document.createTextNode(formatted_number));
			};
			jQuery(document).ready(function() {
				_googWcmGet(callback, '".$yewsPhoneNoCode."');
			});</script>";
		else {return;}
		echo $output;
	}
}

if ( ! function_exists( 'yews_add_hellobarcss_code' ) ) {
	add_action('wp_head','yews_add_hellobarcss_code');
	function yews_add_hellobarcss_code() {
		$yewsHelloBarTextCode = get_theme_mod("yews_hellobartext_code");
		$yewsHelloBarButtonTextCode = get_theme_mod("yews_hellobarbuttontext_code");
		$yewsHelloBarButtonUrlCode = get_theme_mod("yews_hellobarbuttonurl_code");
		$yewsHelloBarBgColorCode = get_theme_mod("yews_hellobarbgcolor_code");
		$yewsHelloBarTextColorCode = get_theme_mod("yews_hellobartextcolor_code");
		$yewsHelloBarButtonBgColorCode = get_theme_mod("yews_hellobarbuttonbgcolor_code");
		$yewsHelloBarButtonTextColorCode = get_theme_mod("yews_hellobarbuttontextcolor_code");
		if (empty($yewsHelloBarBgColorCode)) $yewsHelloBarBgColorCode ="#00ADEF";
		if (empty($yewsHelloBarTextColorCode)) $yewsHelloBarTextColorCode ="#ffffff";
		if (empty($yewsHelloBarButtonBgColorCode)) $yewsHelloBarButtonBgColorCode ="#ffffff";
		if (empty($yewsHelloBarButtonTextColorCode)) $yewsHelloBarButtonTextColorCode ="#00ADEF";
		if ( (!empty($yewsHelloBarTextCode)) && (!empty($yewsHelloBarButtonTextCode)) && (!empty($yewsHelloBarButtonUrlCode)) ) $output="<style>
	#yews-hello-bar { 
		overflow: hidden;width: 100%;background: ".$yewsHelloBarBgColorCode.";color: ".$yewsHelloBarTextColorCode.";text-align: center;padding: 1px 0;
		-moz-animation-name: dropHeader;
		-moz-animation-iteration-count: 1;
		-moz-animation-timing-function: ease-in;
		-moz-animation-duration: 1.5s;

		-webkit-animation-name: dropHeader;
		-webkit-animation-iteration-count: 1;
		-webkit-animation-timing-function: ease-in;
		-webkit-animation-duration: 1.5s;

		animation-name: dropHeader;
		animation-iteration-count: 1;
		animation-timing-function: ease-in;
		animation-duration: 1.5s;
	}
	@-moz-keyframes dropHeader {
		0% {
			-moz-transform: translateY(-40px);
		}
		100% {
			-moz-transform: translateY(0);
		}
	}
	@-webkit-keyframes dropHeader {
		0% {
			-webkit-transform: translateY(-40px);
		}
		100% {
			-webkit-transform: translateY(0);
		}
	}
	@keyframes dropHeader {
		0% {
			transform: translateY(-40px);
		}
		100% {
			transform: translateY(0);
		}
	}

	#yews-hello-bar a {color:".$yewsHelloBarButtonTextColorCode.";background-color: ".$yewsHelloBarButtonBgColorCode.";padding: 4px 16px!important; margin-bottom: 1px;display: inline-block;font-size: 1em;margin-right: 5px;border-width: 0px;outline: none;cursor: pointer;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		font-weight: bold;
		-moz-animation-name: dropHeaderA;
		-moz-animation-iteration-count: 1;
		-moz-animation-timing-function: ease-in;
		-moz-animation-duration: 2s;

		-webkit-animation-name: dropHeaderA;
		-webkit-animation-iteration-count: 1;
		-webkit-animation-timing-function: ease-in;
		-webkit-animation-duration: 2s;

		animation-name: dropHeaderA;
		animation-iteration-count: 1;
		animation-timing-function: ease-in;
		animation-duration: 2s;
	}
	@-moz-keyframes dropHeaderA {
		0% {background-color: ".$yewsHelloBarButtonTextColorCode.";}
		100% {background-color: ".$yewsHelloBarButtonBgColorCode.";}
	}
	@-webkit-keyframes dropHeaderA {
		0% {background-color: ".$yewsHelloBarButtonTextColorCode.";}
		100% {background-color: ".$yewsHelloBarButtonBgColorCode.";}
	}
	@keyframes dropHeaderA {
		0% {background-color: ".$yewsHelloBarButtonTextColorCode.";}
		100% {background-color: ".$yewsHelloBarButtonBgColorCode.";}
	}

	@media screen and (min-width: 768px) {
	 body {padding-top: 31px;}
	 body.admin-bar #yews-hello-bar {top: 32px;}
	 #yews-hello-bar {position: fixed;top: 0;z-index: 99999;}
	 .gdlr-navigation-wrapper.gdlr-style-2.gdlr-fixed-menu, .totalbusiness-header-inner.header-inner-header-style-3.totalbusiness-fixed-header {margin-top: 31px;}
	}
	@media screen and (max-width: 767px) {
	 body {padding-top: 53px;}
	 body.admin-bar #yews-hello-bar {top: 32px;}
	 #yews-hello-bar {position: absolute;top: 0;z-index: 99999;}
	 #yews-hello-bar a {display: block;width: 50%;margin:0 auto;}}
		</style>";
		else {$output="";}
		echo $output;
	}
}
if ( ! function_exists( 'yews_add_hellobarhtml_code' ) ) {
	add_action('wp_footer','yews_add_hellobarhtml_code');
	function yews_add_hellobarhtml_code() {
		$yewsHelloBarTextCode = get_theme_mod("yews_hellobartext_code");
		$yewsHelloBarButtonTextCode = get_theme_mod("yews_hellobarbuttontext_code");
		$yewsHelloBarButtonUrlCode = get_theme_mod("yews_hellobarbuttonurl_code");
		$yewsHelloBarClassesCode = get_theme_mod("yews_hellobarclasses_code");
		if ( (!empty($yewsHelloBarTextCode)) && (!empty($yewsHelloBarButtonTextCode)) && (!empty($yewsHelloBarButtonUrlCode)) ) $output="<div id='yews-hello-bar'>".$yewsHelloBarTextCode." <a class='".$yewsHelloBarClassesCode."' href='".$yewsHelloBarButtonUrlCode."' target='_self'>".$yewsHelloBarButtonTextCode."</a></div>";
		else {$output="";}
		echo $output;
	}
}

if ( ! function_exists( 'yews_add_remarketing_code' ) ) {
	add_action('wp_footer','yews_add_remarketing_code', 999);
	function yews_add_remarketing_code() {
		$yewsAdwordsRemarketing = get_option("yews_codes");
		$yewsAdwordsRemarketingCode = $yewsAdwordsRemarketing['yews_remarketing_code'];
		if (empty($yewsAdwordsRemarketingCode)) {
			$yewsAdwordsRemarketingCode_old = get_option("yews_remarketing_code");
			if (!empty($yewsAdwordsRemarketingCode_old)) {
		  		$yewsAdwordsRemarketingCode = $yewsAdwordsRemarketingCode_old;
		 	}
		 	else {return;}
		}	
		
		if ( (!empty($yewsAdwordsRemarketingCode))) $output="<!-- YEWS Google AdWords Remarketing Code -->".$yewsAdwordsRemarketingCode;
		else {$output="";}
		echo $output;
	}
}

if ( ! function_exists( 'yews_add_conversion_tracking_code' ) ) {
	add_action('wp_footer','yews_add_conversion_tracking_code', 999);
	function yews_add_conversion_tracking_code() {
		$yews_conversion_tracking = get_option("yews_codes");
		$yews_conversion_tracking_code = $yews_conversion_tracking['yews_conversion_tracking_code'];		
		if ( (!empty($yews_conversion_tracking_code))) {$output="<!-- YEWS Conversion Tracking Code -->".$yews_conversion_tracking_code;}
		else {return;}
		$yews_conversion_tracking_pages_code = $yews_conversion_tracking['yews_conversion_tracking_pages_code'];
		$yewsArray = explode(',', $yews_conversion_tracking_pages_code);
		if (!is_page($yewsArray)) {return;}
		echo $output;
	}
}

$yewsBottomBarEnabled = get_theme_mod("yews_bottombar_enabled");
if ($yewsBottomBarEnabled == 1) {
	function yews_add_bottombar_scripts() {
		wp_register_script('yews_bottombar_script', plugins_url().'/yews-optimisations/include/yews/js/bottom-bar.js', array('jquery'), '', true);
		wp_enqueue_script('yews_bottombar_script');
	}
	add_action( 'wp_enqueue_scripts', 'yews_add_bottombar_scripts' ); 
	if ( ! function_exists( 'yews_add_bottom_bar' ) ) {
		add_action('wp_footer','yews_add_bottom_bar', 999);		
		function yews_add_bottom_bar() {
			$yewsBottomBarbuttons = get_theme_mod("yews_bottombar_buttons");
			$yews_bottombar_bgcolor_code = get_theme_mod("yews_bottombar_bgcolor_code");
			$yews_bottombarbutton_1_text_code = get_theme_mod("yews_bottombarbutton_1_text_code");
			$yews_bottombarbutton_1_url_code = get_theme_mod("yews_bottombarbutton_1_url_code");
			$yews_bottombarbutton_1_classes_code = get_theme_mod("yews_bottombarbutton_1_classes_code");
			$yews_bottombarbutton_1_bgcolor_code = get_theme_mod("yews_bottombarbutton_1_bgcolor_code");
			$yews_bottombarbutton_1_textcolor_code = get_theme_mod("yews_bottombarbutton_1_textcolor_code");
			$yews_bottombarbutton_2_text_code = get_theme_mod("yews_bottombarbutton_2_text_code");
			$yews_bottombarbutton_2_url_code = get_theme_mod("yews_bottombarbutton_2_url_code");
			$yews_bottombarbutton_2_classes_code = get_theme_mod("yews_bottombarbutton_2_classes_code");
			$yews_bottombarbutton_2_bgcolor_code = get_theme_mod("yews_bottombarbutton_2_bgcolor_code");
			$yews_bottombarbutton_2_textcolor_code = get_theme_mod("yews_bottombarbutton_2_textcolor_code");
			$yewsBottomBarEnabled = get_theme_mod("yews_bottombar_enabled");
			if ($yewsBottomBarEnabled == 1) {
				echo '<div class="yews-bpanel"><div class="yews-bottom-bar">
				<a class="yews-bottom-button-1 '.$yews_bottombarbutton_1_classes_code.'" href="'.$yews_bottombarbutton_1_url_code.'">'.$yews_bottombarbutton_1_text_code.'</a>';
				if ($yewsBottomBarbuttons == 2) { echo '<a class="yews-bottom-button-2 '.$yews_bottombarbutton_2_classes_code.'" href="'.$yews_bottombarbutton_2_url_code.'">'.$yews_bottombarbutton_2_text_code.'</a>';}
				echo '</div></div>';
				echo '<style>.yews-bpanel { display: none; }
	
					@media screen and (max-width: 767px){
					body {padding-bottom: 50px;}
					.yews-bpanel { display: block !important; }
					
					.yews-bottom-bar{
					    display: none;
					    position: fixed;
					    bottom: 0;
					    width: 100%;
					    background: '.$yews_bottombar_bgcolor_code.';
					    z-index: 999;
					    padding: 10px;
					    text-align: center;
					}
					.yews-bottom-bar a.yews-bottom-button-1{
					    ';
					    if ($yewsBottomBarbuttons == 1) {echo 'width: 70%;';}
					    elseif ($yewsBottomBarbuttons == 2) {echo 'width: 30%;';}
					    echo 'display: inline-block;
					    background: '.$yews_bottombarbutton_1_bgcolor_code.';
					    color: '.$yews_bottombarbutton_1_textcolor_code.';
					    padding: 2px 10px;
					    margin: 0 5px;
					    border-radius: 3px !important;
					    min-height: 40px;
					    text-align: center;
					    line-height: 35px;
					    vertical-align: middle;
					}';
					if ($yewsBottomBarbuttons == 2) {echo '
					.yews-bottom-bar a.yews-bottom-button-2{
					    width: 30%;
					    display: inline-block;
					    background: '.$yews_bottombarbutton_2_bgcolor_code.';
					    color: '.$yews_bottombarbutton_2_textcolor_code.';
					    padding: 2px 10px;
					    margin: 0 5px;
					    border-radius: 3px !important;
					    min-height: 40px;
					    text-align: center;
					    line-height: 35px;
					}';}
					echo '
					}
					
					@media screen and (max-width: 419px){
					    .yews-bottom-bar a.yews-bottom-button-1{
					    font-size: 14px !important;
					';
					    if ($yewsBottomBarbuttons == 1) {echo 'width: 70%!important;}';}
					    elseif ($yewsBottomBarbuttons == 2) {echo 'width: 40%!important;}
					    .yews-bottom-bar a.yews-bottom-button-2 {
						    font-size: 14px !important;
						    width: 40% !important;
					    }';}
					    echo '
					}
					
					}</style>
				';
			}
		}
	}
}