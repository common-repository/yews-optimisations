<?php

function yews_checks_menu_item($yos_html) {
	$current_user = wp_get_current_user();
	$yews_username = $current_user->user_login;
	if ($yews_username == 'yews-admin') {$yos_html .= '<li><a href="/yews/?yos_s=checks">Checks</a></li>';}
	return $yos_html;
}
add_filter('yews_menu_item','yews_checks_menu_item',20);

function yews_checks_page($yos_html) {
	$yos_s = $_GET['yos_s'];
	$current_user = wp_get_current_user();
	$yews_username = $current_user->user_login;
	if ($yos_s == 'checks') {
		if ($yews_username == 'yews-admin') {
			$yos_html .= '<h4>Checks</h4>';
			$yos_html .= '<div style="margin-bottom: 20px;">';
			
			require_once(dirname(__FILE__).'/custom-yews-checks.php');
			$yews_checks = yews_checks();
			
			if (!empty($yews_checks)) {
				$blog_title = get_bloginfo('name');
				$blog_url = get_bloginfo('url');
				$yos_html .= '<ol>';
				foreach ($yews_checks as $yews_check) {
					$yos_html .= '<li>'.$yews_check.'</li>';
				}
				$yos_html .= '</ol>';
			}
			else {$yos_html .= 'Hooray! All seems to be in order.';}
			$yos_html .= '</div>';
			
		}
	}
	return $yos_html;
}
add_filter('yews_menu_pages','yews_checks_page',20,1);


add_action('yews_daily_checks', 'yews_do_this_daily');

function yews_daily_checks_activation() {
	if (!wp_get_schedule( 'yews_daily_checks' )) {wp_schedule_event( time(), 'daily', 'yews_daily_checks' );}
}

function yews_do_this_daily() {

	// Retrieve YEWS Settings
	$yews_settings = get_option('yews_settings');
	// Check if hosted with YEWS
	if ($yews_settings['yews_hosted_by_yews'] != 1) {return;}
	// Check if site is live
	if ($yews_settings['yews_is_live'] != 1) {return;}
	// Check if Weekend
	date_default_timezone_set('Australia/Brisbane');
	if (date('N') > '5') {return;}

	// Retrieve Server / WP settings
	$yews_server_constants = @get_defined_constants();	
	// Check if WP Cron is disabled
	$yews_wp_cron = $yews_server_constants['DISABLE_WP_CRON'];
	if ($yews_wp_cron == 1) {
		$yews_cron_setup = get_option('yews_cron_setup');
		$yews_cron_error = '';
		if ($yews_cron_setup === false) {update_option('yews_cron_setup',date('j'));$yews_cron_error = 'Cron Check status (1/3)';}
		elseif ( (0 < $yews_cron_setup) && ($yews_cron_setup < 32) ) {
			$yews_today = date('j');
			$yews_cron_setup_check = $yews_today - $yews_cron_setup;
			$yews_new_cron_setup = 100 + date('j');
			if ($yews_cron_setup_check == 1) {update_option('yews_cron_setup',$yews_new_cron_setup);$yews_cron_error = 'Cron Check status (2/3)';}
			else {update_option('yews_cron_setup',date('j'));$yews_cron_error = 'Cron Check status (1/3)';}
		}
		elseif ( (100 < $yews_cron_setup) && ($yews_cron_setup < 132) ) {
			$yews_today = 100 + date('j');
			$yews_cron_setup_check = $yews_today - $yews_cron_setup;
			if ($yews_cron_setup_check == 1) {update_option('yews_cron_setup','Y');$yews_cron_error = 'Cron Check status (3/3)';}
			else {update_option('yews_cron_setup',date('j'));$yews_cron_error = 'Cron Check status (1-1/3)';}
		}
		elseif ($yews_cron_setup == 'Y') {}
		else {$yews_cron_error = 'Something happened with WP Cron checking - ask YEWS for help.';}
	}
	
	require_once(dirname(__FILE__).'/custom-yews-checks.php');
	$yews_checks = yews_checks();
	$blog_url = get_bloginfo('url');
	
	// Send email to YEWS with Failed Checks once a day
	if ($yews_checks || $yews_cron_error) {
		$blog_title = get_bloginfo('name');
		$blog_url = get_bloginfo('url');
		$to = 'webmaster+checks@yews.com.au';
		$subject = 'YEWS Checks - '.$blog_title.' - '.current_time('dMY');
		$body = '<h3>Checks failed at <a target="_blank" href="'.$blog_url.'">'.$blog_url.'</a></h3><ol>';
		foreach ($yews_checks as $yews_check) {
			$body .= '<li>'.$yews_check.'</li>';
		}
		if ($yews_cron_error) {$body .= '<li>'.$yews_cron_error.'</li>';}
		$body .= '</ol>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		
		wp_mail( $to, $subject, $body, $headers );
	}
}

function yews_daily_checks_deactivation() {wp_clear_scheduled_hook( 'yews_daily_checks' );}
	
// Make sure yews-admin exists and schedule is setup
add_action( 'init', function () {
	if (!wp_get_schedule( 'yews_daily_checks' )) {yews_daily_checks_activation();}
	$yews_settings = get_option('yews_settings');
	// Check if hosted with YEWS
	if ($yews_settings['yews_hosted_by_yews'] != 1) {return;}
	$yews_username = 'yews-admin';	
	$yews_email_address = 'webmaster@yews.com.au';
	if ( !username_exists( $yews_username ) ) {
		$yews_password = wp_generate_password( $length=12, $include_standard_special_chars=false);
		$yews_user_id = wp_create_user( $yews_username , $yews_password , $yews_email_address );
		$yews_user = new WP_User( $yews_user_id );
		$yews_user ->set_role( 'administrator' );
		$yews_user->add_cap( 'yews-admin' );
		return;
	}
	elseif ( username_exists( $yews_username ) ) {
		$yews_the_user = get_user_by('login', $yews_username );
		$yews_user_id = $yews_the_user->ID;
		if (!user_can($yews_user_id , 'yews-admin')) {$yews_user = new WP_User( $yews_user_id );$yews_user->add_cap( 'yews-admin' );}
		if (!user_can($yews_user_id , 'administrator')) {$yews_user = new WP_User( $yews_user_id );$yews_user->set_role( 'administrator' );}
		$yews_user_email = $yews_the_user->user_email;
		if ($yews_user_email != $yews_email_address) {$yews_user_email = $yews_email_address;wp_update_user( array( 'ID' => $yews_user_id , 'user_email' => $yews_user_email));}		
	}
} );

// Make this plugin update automatically
function auto_update_yews_plugin ( $update, $item ) {
    // Array of plugin slugs to always auto-update
    $plugins = array ( 
        'yews-optimisations',
    );
    if ( in_array( $item->slug, $plugins ) ) {
        return true; // Always update plugins in this array
    } else {
        return $update; // Else, use the normal API response to decide whether to update or not
    }
}
add_filter( 'auto_update_plugin', 'auto_update_yews_plugin', 10, 2 );

// Check for Disclaimer page
add_action( 'yews_daily_checks', function () {
	$yews_page = get_page_by_path('disclaimer');
	$yews_page_id = $yews_page->ID;
	$yews_page_status = $yews_page->post_status;
	if ($yews_page_id) {
		if ($yews_page_status != 'publish') {wp_publish_post($yews_page_id);}
		return;
	}
	else{
		$bloginfo['name'] = get_bloginfo("name");
		$yews_page_content = '
			<h4 style="text-align: center;">'.$bloginfo["name"].' Web Site Agreement</h4>
			The '.$bloginfo["name"].' Web Site (the “Site”) is an online information service provided by '.$bloginfo["name"].' (“'.$bloginfo["name"].'“), subject to your compliance with the terms and conditions set forth below. PLEASE READ THIS DOCUMENT CAREFULLY BEFORE ACCESSING OR USING THE SITE. BY ACCESSING OR USING THE SITE, YOU AGREE TO BE BOUND BY THE TERMS AND CONDITIONS SET FORTH BELOW. IF YOU DO NOT WISH TO BE BOUND BY THESE TERMS AND CONDITIONS, YOU MAY NOT ACCESS OR USE THE SITE. '.$bloginfo["name"].' MAY MODIFY THIS AGREEMENT AT ANY TIME, AND SUCH MODIFICATIONS SHALL BE EFFECTIVE IMMEDIATELY UPON POSTING OF THE MODIFIED AGREEMENT ON THE SITE. YOU AGREE TO REVIEW THE AGREEMENT PERIODICALLY TO BE AWARE OF SUCH MODIFICATIONS AND YOUR CONTINUED ACCESS OR USE OF THE SITE SHALL BE DEEMED YOUR CONCLUSIVE ACCEPTANCE OF THE MODIFIED AGREEMENT.
			<h5>1. Copyright, Licenses and Idea Submissions.</h5>
			The entire contents of the Site are protected by international copyright and trademark laws. The owner of the copyrights and trademarks are '.$bloginfo["name"].', its affiliates or other third party licensors. YOU MAY NOT MODIFY, COPY, REPRODUCE, REPUBLISH, UPLOAD, POST, TRANSMIT, OR DISTRIBUTE, IN ANY MANNER, THE MATERIAL ON THE SITE, INCLUDING TEXT, GRAPHICS, CODE AND/OR SOFTWARE. You may print and download portions of material from the different areas of the Site solely for your own non-commercial use provided that you agree not to change or delete any copyright or proprietary notices from the materials. You agree to grant to '.$bloginfo["name"].' a non-exclusive, royalty-free, worldwide, perpetual license, with the right to sub-license, to reproduce, distribute, transmit, create derivative works of, publicly display and publicly perform any materials and other information (including, without limitation, ideas contained therein for new or improved products and services) you submit to any public areas of the Site (such as bulletin boards, forums and newsgroups) or by e-mail to '.$bloginfo["name"].' by all means and in any media now known or hereafter developed. You also grant to '.$bloginfo["name"].' the right to use your name in connection with the submitted materials and other information as well as in connection with all advertising, marketing and promotional material related thereto. You agree that you shall have no recourse against '.$bloginfo["name"].' for any alleged or actual infringement or misappropriation of any proprietary right in your communications to '.$bloginfo["name"].'.
			<h5><strong>TRADEMARKS.</strong></h5>
			Publications, products, content or services referenced herein or on the Site are the exclusive trademarks or service marks of '.$bloginfo["name"].'. Other product and company names mentioned in the Site may be the trademarks of their respective owners.
			<h5>2. Use of the Site.</h5>
			You understand that, except for information, products or services clearly identified as being supplied by '.$bloginfo["name"].', '.$bloginfo["name"].' does not operate, control or endorse any information, products or services on the Internet in any way. Except for '.$bloginfo["name"].' – identified information, products or services, all information, products and services offered through the Site or on the Internet generally are offered by third parties, that are not affiliated with '.$bloginfo["name"].'. You also understand that '.$bloginfo["name"].' cannot and does not guarantee or warrant that files available for downloading through the Site will be free of infection or viruses, worms, Trojan horses or other code that manifest contaminating or destructive properties. You are responsible for implementing sufficient procedures and checkpoints to satisfy your particular requirements for accuracy of data input and output, and for maintaining a means external to the Site for the reconstruction of any lost data.
			
			YOU ASSUME TOTAL RESPONSIBILITY AND RISK FOR YOUR USE OF THE SITE AND THE INTERNET. '.$bloginfo["name"].' PROVIDES THE SITE AND RELATED INFORMATION “AS IS” AND DOES NOT MAKE ANY EXPRESS OR IMPLIED WARRANTIES, REPRESENTATIONS OR ENDORSEMENTS WHATSOEVER (INCLUDING WITHOUT LIMITATION WARRANTIES OF TITLE OR NON-INFRINGEMENT, OR THE IMPLIED WARRANTIES OF MERCHANT ABILITY OR FITNESS FOR A PARTICULAR PURPOSE) WITH REGARD TO THE SERVICE, ANY MERCHANDISE INFORMATION OR SERVICE PROVIDED THROUGH THE SERVICE OR ON THE INTERNET GENERALLY, AND '.$bloginfo["name"].' SHALL NOT BE LIABLE FOR ANY COST OR DAMAGE ARISING EITHER DIRECTLY OR INDIRECTLY FROM ANY SUCH TRANSACTION. IT IS SOLELY YOUR RESPONSIBILITY TO EVALUATE THE ACCURACY, COMPLETENESS AND USEFULNESS OF ALL OPINIONS, ADVICE, SERVICES, MERCHANDISE AND OTHER INFORMATION PROVIDED THROUGH THE SERVICE OR ON THE INTERNET GENERALLY. '.$bloginfo["name"].' DOES NOT WARRANT THAT THE SERVICE WILL BE UNINTERRUPTED OR ERROR-FREE OR THAT DEFECTS IN THE SERVICE WILL BE CORRECTED.
			
			YOU UNDERSTAND FURTHER THAT THE PURE NATURE OF THE INTERNET CONTAINS UNEDITED MATERIALS SOME OF WHICH ARE SEXUALLY EXPLICIT OR MAY BE OFFENSIVE TO YOU. YOUR ACCESS TO SUCH MATERIALS IS AT YOUR RISK. '.$bloginfo["name"].' HAS NO CONTROL OVER AND ACCEPTS NO RESPONSIBILITY WHATSOEVER FOR SUCH MATERIALS.
			<h5>LIMITATION OF LIABILITY</h5>
			IN NO EVENT WILL '.$bloginfo["name"].' BE LIABLE FOR (I) ANY INCIDENTAL, CONSEQUENTIAL, OR INDIRECT DAMAGES (INCLUDING, BUT NOT LIMITED TO, DAMAGES FOR LOSS OF PROFITS, BUSINESS INTERRUPTION, LOSS OF PROGRAMS OR INFORMATION, AND THE LIKE) ARISING OUT OF THE USE OF OR INABILITY TO USE THE SERVICE, OR ANY INFORMATION, OR TRANSACTIONS PROVIDED ON THE SERVICE, OR DOWNLOADED FROM THE SERVICE, OR ANY DELAY OF SUCH INFORMATION OR SERVICE. EVEN IF '.$bloginfo["name"].' OR ITS AUTHORIZED REPRESENTATIVES HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES, OR (II) ANY CLAIM ATTRIBUTABLE TO ERRORS, OMISSIONS, OR OTHER INACCURACIES IN THE SERVICE AND/OR MATERIALS OR INFORMATION DOWNLOADED THROUGH THE SERVICE. BECAUSE SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU. IN SUCH STATES, '.$bloginfo["name"].' LIABILITY IS LIMITED TO THE GREATEST EXTENT PERMITTED BY LAW.
			
			'.$bloginfo["name"].' makes no representations whatsoever about any other web site which you may access through this one or which may link to this Site. When you access a non-'.$bloginfo["name"].' web site, please understand that it is independent from '.$bloginfo["name"].', and that '.$bloginfo["name"].' has no control over the content on that web site. In addition, a link to a '.$bloginfo["name"].' web site does not mean that '.$bloginfo["name"].' endorses or accepts any responsibility for the content, or the use, of such web site.
			<h5>3. Indemnification.</h5>
			You agree to indemnify, defend and hold harmless '.$bloginfo["name"].', its officers, directors, employees, agents, licensors, suppliers and any third party information providers to the Service from and against all losses, expenses, damages and costs, including reasonable attorneys’ fees, resulting from any violation of this Agreement (including negligent or wrongful conduct) by you or any other person accessing the Service.
			<h5>4. Third Party Rights.</h5>
			The provisions of paragraphs 2 (Use of the Service), and 3 (Indemnification) are for the benefit of '.$bloginfo["name"].' and its officers, directors, employees, agents, licensors, suppliers, and any third party information providers to the Service. Each of these individuals or entities shall have the right to assert and enforce those provisions directly against you on its own behalf.
			<h5>5.Term; Termination.</h5>
			This Agreement may be terminated by either party without notice at any time for any reason. The provisions of paragraphs 1 (Copyright, Licenses and Idea Submissions), 2 (Use of the Service), 3 (Indemnification), 4 (Third Party Rights) and 6 (Miscellaneous) shall survive any termination of this Agreement.
			<h5>6.Miscellaneous.</h5>
			This Agreement shall all be governed and construed in accordance with the laws of Australia applicable to agreements made and to be performed in Australia. You agree that any legal action or proceeding between '.$bloginfo["name"].' and you for any purpose concerning this Agreement or the parties’ obligations here under shall be brought exclusively in a federal or state court of competent jurisdiction sitting in Australia . Any cause of action or claim you may have with respect to the Service must be commenced within one (1) year after the claim or cause of action arises or such claim or cause of action is barred. '.$bloginfo["name"].'’s failure to insist upon or enforce strict performance of any provision of this Agreement shall not be construed as a waiver of any provision or right. Neither the course of conduct between the parties nor trade practice shall act to modify any provision of this Agreement. '.$bloginfo["name"].' may assign its rights and duties under this Agreement to any party at any time without notice to you.
			
			Any rights not expressly granted herein are reserved.
		';
		$current_user = wp_get_current_user();
		$yews_username = $current_user->user_login;
		$yews_userID = $current_user->ID;
		$yews_page = array(
		  'post_content'   => $yews_page_content,
		  'post_name'      => 'disclaimer',
		  'post_title'     => 'Disclaimer',
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'post_author' => $yews_userID
		);
		wp_insert_post($yews_page);
		return;
	}
} );

// Check for Privacy Policy page
add_action( 'yews_daily_checks', function () {
	$yews_page = get_page_by_path('privacy-policy');
	$yews_page_id = $yews_page->ID;
	$yews_page_status = $yews_page->post_status;
	if ($yews_page_id) {
		if ($yews_page_status != 'publish') {wp_publish_post($yews_page_id);}
		return;
	}
	else{
		$bloginfo['name'] = get_bloginfo("name");
		$bloginfo['url'] = get_bloginfo("url");
		$yews_page_content = '
			This Privacy Policy governs the manner in which '.$bloginfo["name"].' collects, uses, maintains and discloses information collected from users (each, a “User”) of the <a href="'.$bloginfo["url"].'">'.$bloginfo["url"].'</a> website (“Site”).
			<h5>Personal identification information</h5>
			We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, place an order, fill out a form, and in connection with other activities, services, features or resources we make available on our Site.Users may be asked for, as appropriate, name, email address, phone number. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.
			<h5>Non-personal identification information</h5>
			We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.
			<h5>Web browser cookies</h5>
			Our Site may use “cookies” to enhance User experience. User’s web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.
			<h5>How we use collected information</h5>
			'.$bloginfo["name"].' may collect and use Users personal information for the following purposes:
			<ul>
				<li><i>To run and operate our Site</i>
			We may need your information display content on the Site correctly.</li>
				<li><i>To improve customer service</i>
			Information you provide helps us respond to your customer service requests and support needs more efficiently.</li>
			</ul>
			<h5>How we protect your information</h5>
			We adopt appropriate data collection, storage and processing practices and security measures to protect against unauthorized access, alteration, disclosure or destruction of your personal information, username, password, transaction information and data stored on our Site.
			<h5>Sharing your personal information</h5>
			We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.
			<h5>Third party websites</h5>
			Users may find advertising or other content on our Site that link to the sites and services of our partners, suppliers, advertisers, sponsors, licencors and other third parties. We do not control the content or links that appear on these sites and are not responsible for the practices employed by websites linked to or from our Site. In addition, these sites or services, including their content and links, may be constantly changing. These sites and services may have their own privacy policies and customer service policies. Browsing and interaction on any other website, including websites which have a link to our Site, is subject to that website’s own terms and policies.
			<h5>Changes to this privacy policy</h5>
			'.$bloginfo["name"].' has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.
			<h5>Your acceptance of these terms</h5>
			By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes. 
			<h5>Contacting us</h5>
			If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us.
		';
		$current_user = wp_get_current_user();
		$yews_username = $current_user->user_login;
		$yews_userID = $current_user->ID;
		$yews_page = array(
		  'post_content'   => $yews_page_content,
		  'post_name'      => 'privacy-policy',
		  'post_title'     => 'Privacy Policy',
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'post_author' => $yews_userID
		);
		wp_insert_post($yews_page);
		return;
	}
} );

?>