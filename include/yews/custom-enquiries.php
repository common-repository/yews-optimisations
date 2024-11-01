<?php

function yews_enquiries_menu_item($yos_html) {
	$yos_html .= '<li><a href="/yews/?yos_s=enquiries">Enquiries</a></li>';
	return $yos_html;
}
add_filter('yews_menu_item','yews_enquiries_menu_item',10);

function yews_enquiries_page($yos_html){
			$current_user = wp_get_current_user();
			$yews_username = $current_user->user_login;
			$yews_userID = $current_user->ID;
			if ($_GET['yos_s'] == 'enquiries') {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );				
				$yos_html .= '<h4>Enquiries - <a style="font-size: 0.5em;" href="/yews/?yos_s=enquiries-spam">View Spam</a></h4>';
				if (!is_plugin_active('contact-form-7/wp-contact-form-7.php')) {$yos_html .= '<p style="color: #f00;font-weight: bold;">You do not have Contact Form 7 WordPress Plugin active. This is required for this section to work properly.</p>';}
				if (!is_plugin_active('flamingo/flamingo.php')) {$yos_html .= '<p style="color: #f00;font-weight: bold;"">You do not have Flamingo WordPress Plugin active. This is required for this section to work properly.</p>';}
				global $paged;
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
				'post_type' => 'flamingo_inbound',
				'post_status' => 'publish',
		                'posts_per_page' => 150,
		                'paged' => $paged
				);				
				$loop = new WP_Query( $args );
				$yos_html .= '<div><div class="older" style="float: left;">'.get_next_posts_link("&laquo; Older Entries", $loop->max_num_pages).'</div>';
				$yos_html .= '<div class="newer" style="float: right;">'.get_previous_posts_link('Newer Entries &raquo;').'</div></div>';
				
				$yos_html .= '<table class="style-2"><th>Type</th><th>Date</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>';
				while ( $loop->have_posts() ) : $loop->the_post();
					$yos_postID = $loop->post->ID;
					$yos_post_meta = get_post_meta($yos_postID);
					$delete_link = admin_url(sprintf( 'admin.php?page=flamingo_inbound&post=%s&action=trash', $yos_postID ) );
					$delete_link = wp_nonce_url( $delete_link, 'flamingo-trash-inbound-message_' . $yos_postID );
					$yos_html .= '<tr><td>'.get_the_title().'</td><td>'.get_the_time('Y-m-d').'</td><td>'.$yos_post_meta['_field_your-name'][0].'</td><td>'.$yos_post_meta['_field_your-email'][0].'</td><td>'.$yos_post_meta['_field_your-phone'][0].'</td><td><a href="'.get_admin_url('','admin.php?page=flamingo_inbound&post='.$yos_postID.'&action=edit').'" target="_blank">Open</a> - <a href="'.$delete_link.'">Delete</a></td></tr>';
				endwhile;
				$yos_html .= '</table>';
				$yos_html .= '<div><div class="older" style="float: left;">'.get_next_posts_link("&laquo; Older Entries", $loop->max_num_pages).'</div>';
				$yos_html .= '<div class="newer" style="float: right;">'.get_previous_posts_link('Newer Entries &raquo;').'</div></div>';
			}
			elseif ($_GET['yos_s'] == 'enquiries-spam') {
				$yos_html .= '<h4>Enquiries (SPAM) - <a style="font-size: 0.5em;"  href="/yews/?yos_s=enquiries">Inbox</a></h4>';
				$args = array(
				'post_type' => 'flamingo_inbound',
				'post_status' => 'flamingo-spam',
		                'posts_per_page' => 150,
		                'paged' => $paged
				);
			
				$loop = new WP_Query( $args );
				$yos_html .= '<div><div class="older" style="float: left;">'.get_next_posts_link("&laquo; Older Entries", $loop->max_num_pages).'</div>';
				$yos_html .= '<div class="newer" style="float: right;">'.get_previous_posts_link('Newer Entries &raquo;').'</div></div>';
				$yos_html .= '<table class="style-2"><th>Type</th><th>Date</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>';
				while ( $loop->have_posts() ) : $loop->the_post();
					$yos_postID = $loop->post->ID;
					$yos_post_meta = get_post_meta($yos_postID);
					$delete_link = admin_url(sprintf( 'admin.php?page=flamingo_inbound&post=%s&action=trash', $yos_postID ) );
					$delete_link = wp_nonce_url( $delete_link, 'flamingo-trash-inbound-message_' . $yos_postID );
					$yos_html .= '<tr><td>'.get_the_title().'</td><td>'.get_the_time('Y-m-d').'</td><td>'.$yos_post_meta['_field_your-name'][0].'</td><td>'.$yos_post_meta['_field_your-email'][0].'</td><td>'.$yos_post_meta['_field_your-phone'][0].'</td><td><a href="'.admin_url( 'admin.php?page=flamingo_inbound&post='.$yos_postID.'&action=edit').'" target="_blank">Open</a> - <a href="'.$delete_link.'">Delete</a></td></tr>';
				endwhile;
				$yos_html .= '</table>';
				$yos_html .= '<div><div class="older" style="float: left;">'.get_next_posts_link("&laquo; Older Entries", $loop->max_num_pages).'</div>';
				$yos_html .= '<div class="newer" style="float: right;">'.get_previous_posts_link('Newer Entries &raquo;').'</div></div>';
			}
			return $yos_html;
}
add_filter('yews_menu_pages','yews_enquiries_page',10,1);