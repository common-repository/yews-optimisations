<?php
if ( ! function_exists( 'yews_custom_login_page_style' ) ) {
	function yews_custom_login_page_style() {echo '<style>
		html {
			background-color: #00ADEF;
			background-image: repeating-linear-gradient(120deg, rgba(255,255,255,.1), rgba(255,255,255,.1) 1px, transparent 1px, transparent 60px), repeating-linear-gradient(60deg, rgba(255,255,255,.1), rgba(255,255,255,.1) 1px, transparent 1px, transparent 60px), linear-gradient(60deg, rgba(0,0,0,.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,.1) 75%, rgba(0,0,0,.1)), linear-gradient(120deg, rgba(0,0,0,.1) 25%, transparent 25%, transparent 75%, rgba(0,0,0,.1) 75%, rgba(0,0,0,.1));
			background-size: 70px 120px;
	}

		body.login { background-color: transparent; width: 100%;max-width: 355px;margin: 0 auto;}
		@media screen and (max-width: 709px) {body.login {max-width: 355px;}}

		.login h1 a {margin: 10px auto 10px;}
		.login form {padding: 26px 24px;}
		#loginh2 {padding:0 25px;color: #333;margin: 10px 0;padding-top: 10px;text-align: center;}
		#loginmessage {padding:0 25px;color: #000;font-size: 1.3em;}

		#login {
			width: 348px;
			margin-right: 5px;
			padding-top: 0;
			background: #fff;
			margin-bottom: 5px;
			padding-bottom: 15px;
			box-shadow: 5px 7px 10px rgba(50, 50, 50,0.75);
			border: 1px solid #999;
			position: absolute;
			top: 10%;
			border-radius: 5px;
		}
		#login h1 a {
			background-image: url(/wp-content/plugins/yews-optimisations/assets/logo.png) !important;
			width: 309px!important;
			height: 100px!important;
			margin-bottom: 0;
			margin: 10px 20px 0;
			background-size: contain;
		}

		#loginform {
			background-color: #fff;
			margin-top: 0;
			box-shadow: none;
			padding: 10px 24px 0;
		}

		#loginform label {color: #000;}
		</style>';
	}
	add_action('login_head', 'yews_custom_login_page_style');
}

if ( ! function_exists( 'yews_wp_login_url' ) ) {
	function yews_wp_login_url() {return 'https://yews.com.au';}
	add_filter('login_headerurl', 'yews_wp_login_url');
}

if ( ! function_exists( 'yews_wp_login_title' ) ) {
	function yews_wp_login_title() {return 'Your Easy Web Solutions';}
	add_filter('login_headertitle', 'yews_wp_login_title');
}

if ( ! function_exists( 'yews_custom_login_message' ) ) {
	function yews_custom_login_message() {
		$loginmessage = '<h2 id="loginh2">WordPress login</h2>';
		return $loginmessage;
	}
	add_filter('login_message', 'yews_custom_login_message');
}