<?php
	
function yews_copyright_years() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
		$copyright = $copyright_dates[0]->firstdate;
		$copyright_last_date = $copyright_dates[0]->lastdate;
		$current_year = date("Y");
		if ($copyright_dates[0]->lastdate < $current_year) {$copyright_last_date = $current_year;}
		if($copyright_dates[0]->firstdate != $copyright_last_date) {			
			$copyright .= ' - ' . $copyright_last_date;
		}
		$output = $copyright;
	}
	return $output;
}

function yews_add_footer_jquery($yews_html) {
	$site_title = get_bloginfo( 'name' );
	$yewsFooterCredits = get_option("yews_footer_credits",'<a href="https://yews.com.au/small-business-web-design">Web Design</a> by YEWS | ');
	$current_theme = wp_get_theme();
	$yews_html['left'] = '<p style=\"letter-spacing: 0px!important;\">Copyright &copy; '.yews_copyright_years().' | '.$site_title.'. All Rights Reserved.</p>';
	$yews_html['right'] = '<p style=\"text-align: right;letter-spacing: 0px!important;\">'.$yewsFooterCredits.'<a href=\"/privacy-policy\">Privacy Policy</a> | <a href=\"/disclaimer\">Disclaimer</a> | <a href=\"/wp-admin\" target=\"_blank\" style=\"display: inline-block;overflow: hidden;border: 1px solid !important;border-radius: 3px;padding: 6px;width: 1px;margin: 0 0 -3px;\"></a></p>';
	if ('infinite' == $current_theme->get('Template')) {
		$yews_copyright_enable = get_option('gdlr_general')['enable-footer'];
		$yews_copyright_text = get_option('gdlr_general')['copyright-text'];
		if ( ($yews_copyright_enable == 'enable') && (!empty($yews_copyright_text)) ) {
		   	echo "<script>jQuery(document).ready(function($){
			$('.infinite-copyright-text').append('<div style=\"clear: both;display:block;overflow:hidden;margin-top: 20px;\"><div class=\"copyright-left\" style=\"float: left;margin: 0 15px;display: inline;\"></div><div class=\"copyright-right\" style=\"float: right;margin: 0 15px;display: inline;\"></div></div>');
			});
			</script>";
		}
		elseif ( ($yews_copyright_enable == 'enable') && (empty($yews_copyright_text)) ) {
			
		   	echo "<script>jQuery(document).ready(function($){
		   	$('footer').append('<div class=\"infinite-copyright-wrapper\"><div class=\"infinite-copyright-container infinite-container\"><div class=\"infinite-copyright-text infinite-item-pdlr\"></div></div></div>');
			$('.infinite-copyright-text').append('<div style=\"clear: both;display:block;overflow:hidden;\"><div class=\"copyright-left\" style=\"float: left;margin: 0 15px;display: inline;\"></div><div class=\"copyright-right\" style=\"float: right;margin: 0 15px;display: inline-table;\"></div></div>');
			});
			</script>";
		}
		elseif ( $yews_copyright_enable == 'disable') {			
		   	echo "<script>jQuery(document).ready(function($){
		   	$('footer').append('<div class=\"infinite-copyright-wrapper\"><div class=\"infinite-copyright-container infinite-container\"><div class=\"infinite-copyright-text infinite-item-pdlr\"></div></div></div>');
			$('.infinite-copyright-text').append('<div style=\"clear: both;display:block;overflow:hidden;\"><div class=\"copyright-left\" style=\"float: left;margin: 0 15px;display: inline;\"></div><div class=\"copyright-right\" style=\"float: right;margin: 0 15px;display: inline-table;\"></div></div>');
			});
			</script>";
		}
	}	
    	echo "<script>jQuery(document).ready(function($){
	$('.copyright-left').append('".$yews_html['left']."');
	$('.copyright-right').append('".$yews_html['right']."');
	});
	</script>";
}
add_action( 'wp_footer', 'yews_add_footer_jquery', 999 );
