<?php

function yews_microstructureddata_menu_item($yos_html) {
	$yos_html .= '<li><a href="/yews/?yos_s=msd">Micro Data</a></li>';
	return $yos_html;
}
add_filter('yews_menu_item','yews_microstructureddata_menu_item',30);

function yews_microstructureddata_page($yos_html) {
	if ($_GET['yos_s'] == 'msd') {
		if ($_POST['update'] == '1') {
			if ($_POST['yews_business_name']) {update_post_meta(get_the_ID(), 'yews_business_name', $_POST['yews_business_name']);}
			if ($_POST['yews_business_phone']) {update_post_meta(get_the_ID(), 'yews_business_phone', $_POST['yews_business_phone']);}
			if ($_POST['yews_business_street_address']) {update_post_meta(get_the_ID(), 'yews_business_street_address', $_POST['yews_business_street_address']);}
			if ($_POST['yews_business_suburb']) {update_post_meta(get_the_ID(), 'yews_business_suburb', $_POST['yews_business_suburb']);}
			if ($_POST['yews_business_state']) {update_post_meta(get_the_ID(), 'yews_business_state', $_POST['yews_business_state']);}
			if ($_POST['yews_business_post_code']) {update_post_meta(get_the_ID(), 'yews_business_post_code', $_POST['yews_business_post_code']);}
		}
		$yews_business_name = get_post_meta(get_the_ID(), 'yews_business_name', true);
		$yews_business_phone = get_post_meta(get_the_ID(), 'yews_business_phone', true);
		$yews_business_street_address = get_post_meta(get_the_ID(), 'yews_business_street_address', true);
		$yews_business_suburb = get_post_meta(get_the_ID(), 'yews_business_suburb', true);
		$yews_business_state = get_post_meta(get_the_ID(), 'yews_business_state', true);
		$yews_business_post_code = get_post_meta(get_the_ID(), 'yews_business_post_code', true);
		$yos_html .= '<h4>Micro Structured Data</h4>';
		$yos_html .= '<div style="margin-bottom: 20px;">';
		$yos_html .= '<form method="post" action="/yews/?yos_s=msd" class="yews-msd-form">';
		$yos_html .= '<div><div>Business Name:</div><div><input type="text" name="yews_business_name" value="'.$yews_business_name.'" /></div></div>';
		$yos_html .= '<div><div>Business Phone:</div><div><input type="text" name="yews_business_phone" value="'.$yews_business_phone.'" /></div></div>';
		$yos_html .= '<div><div>Street Address:</div><div><input type="text" name="yews_business_street_address" value="'.$yews_business_street_address.'" /></div></div>';
		$yos_html .= '<div><div>Suburb:</div><div><input type="text" name="yews_business_suburb" value="'.$yews_business_suburb.'" /></div></div>';
		$yos_html .= '<div><div>State:</div><div><input type="text" name="yews_business_state" value="'.$yews_business_state.'" /></div></div>';
		$yos_html .= '<div><div>Post Code:</div><div><input type="text" name="yews_business_post_code" value="'.$yews_business_post_code.'" /></div></div>';
		$yos_html .= '<input type="hidden" name="update" value="1" />';
		$yos_html .= '<input type="submit" value="Update">';
		$yos_html .= '</form>';
		$yos_html .= '<style>.yews-msd-form input {max-width: 250px!important;} .yews-msd-form div div:nth-child(odd) {width: 200px;} .yews-msd-form div div {display: inline-block;margin-bottom: 3px;}</style>';
		$yos_html .= '</div>';
	}
	return $yos_html;
}
add_filter('yews_menu_pages','yews_microstructureddata_page');

function yews_msd_wp_head() {
	$yews_page = get_page_by_path('yews');
	$yews_page_id = $yews_page->ID;
	$yews_business_name = get_post_meta($yews_page_id, 'yews_business_name', true);
	$yews_business_phone = get_post_meta($yews_page_id, 'yews_business_phone', true);
	$yews_business_street_address = get_post_meta($yews_page_id, 'yews_business_street_address', true);
	$yews_business_suburb = get_post_meta($yews_page_id, 'yews_business_suburb', true);
	$yews_business_state = get_post_meta($yews_page_id, 'yews_business_state', true);
	$yews_business_post_code = get_post_meta($yews_page_id, 'yews_business_post_code', true);
	echo '
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "LocalBusiness",';
  	if ($yews_business_name) {echo '
  "name": "'.$yews_business_name.'",';}
  	if ($yews_business_phone) {echo '
  "telephone": "'.$yews_business_phone.'",';}
  	echo '
  "url" : "'.get_site_url().'",
  "address": {
    "@type": "PostalAddress",';
    	if ($yews_business_street_address) {echo '
    "streetAddress": "'.$yews_business_street_address.'",';}
    	if ($yews_business_suburb) {echo '
    "addressLocality": "'.$yews_business_suburb.'",';}
    	if ($yews_business_state) {echo '
    "addressRegion": "'.$yews_business_state.'",';}
    	if ($yews_business_post_code) {echo '
    "postalCode": "'.$yews_business_post_code.'"';}
    	echo '
  }
}
</script>';
}
add_action('wp_head', 'yews_msd_wp_head');