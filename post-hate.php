<?php
/*
Name:  WordPress Post hate System
Description:  A simple and efficient post hate system for WordPress.
Version:      0.4
Author:       Jon Masterson
Author URI:   http://jonmasterson.com/

License:
Copyright (C) 2014 Jon Masterson

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
 
/**
 * (1) Enqueue scripts for hate system
 */
function hate_scripts() {
	wp_enqueue_script( 'plugins-js', get_template_directory_uri().'/js/plugins.js', false, false, true);
	wp_localize_script( 'plugins-js', 'ajax_var', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' )
		)
	);
}
add_action( 'init', 'hate_scripts' );

/**
 * (2) Add Fontawesome Icons (optional, if not already added in theme)
 *
function enqueue_icons () {
	wp_register_style( 'icon-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css' );
    wp_enqueue_style( 'icon-style' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_icons' );
*/

/**
 * (3) Save hate data
 */
add_action( 'wp_ajax_nopriv_jm-post-hate', 'jm_post_hate' );
add_action( 'wp_ajax_jm-post-hate', 'jm_post_hate' );
function jm_post_hate() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
	
	if ( isset( $_POST['jm_post_hate'] ) ) {
	
		$post_id = $_POST['post_id']; // post id
		$post_hate_count = get_post_meta( $post_id, "_post_hate_count", true ); // post hate count
		
		if ( function_exists ( 'wp_cache_post_change' ) ) {
			$GLOBALS["super_cache_enabled"]=1;
			wp_cache_post_change( $post_id );
		}
		
		if ( is_user_logged_in() ) { // user is logged in
			$user_id = get_current_user_id(); // current user
			$meta_POSTS = get_user_option( "_hated_posts", $user_id  ); // post ids from user meta
			$meta_USERS = get_post_meta( $post_id, "_user_hated" ); // user ids from post meta
			$hated_POSTS = NULL; // setup array variable
			$hated_USERS = NULL; // setup array variable
			
			if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
				$hated_POSTS = $meta_POSTS;
			}
			
			if ( !is_array( $hated_POSTS ) ) // make array just in case
				$hated_POSTS = array();
				
			if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
				$hated_USERS = $meta_USERS[0];
			}		

			if ( !is_array( $hated_USERS ) ) // make array just in case
				$hated_USERS = array();
				
			$hated_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
			$hated_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
			$user_hates = count( $hated_POSTS ); // count user hates
	
			if ( !Alreadyhated( $post_id ) ) { // hate the post
				update_post_meta( $post_id, "_user_hated", $hated_USERS ); // Add user ID to post meta
				update_post_meta( $post_id, "_post_hate_count", ++$post_hate_count ); // +1 count post meta
				update_user_option( $user_id, "_hated_posts", $hated_POSTS ); // Add post ID to user meta
				update_user_option( $user_id, "_user_hate_count", $user_hates ); // +1 count user meta
				echo $post_hate_count; // update count on front end

			} else { // unhate the post
				$pid_key = array_search( $post_id, $hated_POSTS ); // find the key
				$uid_key = array_search( $user_id, $hated_USERS ); // find the key
				unset( $hated_POSTS[$pid_key] ); // remove from array
				unset( $hated_USERS[$uid_key] ); // remove from array
				$user_hates = count( $hated_POSTS ); // recount user hates
				update_post_meta( $post_id, "_user_hated", $hated_USERS ); // Remove user ID from post meta
				update_post_meta($post_id, "_post_hate_count", --$post_hate_count ); // -1 count post meta
				update_user_option( $user_id, "_hated_posts", $hated_POSTS ); // Remove post ID from user meta			
				update_user_option( $user_id, "_user_hate_count", $user_hates ); // -1 count user meta
				echo "already".$post_hate_count; // update count on front end
				
			}
			
		} else { // user is not logged in (anonymous)
			$ip = $_SERVER['REMOTE_ADDR']; // user IP address
			$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
			$hated_IPS = NULL; // set up array variable
			
			if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
				$hated_IPS = $meta_IPS[0];
			}
	
			if ( !is_array( $hated_IPS ) ) // make array just in case
				$hated_IPS = array();
				
			if ( !in_array( $ip, $hated_IPS ) ) // if IP not in array
				$hated_IPS['ip-'.$ip] = $ip; // add IP to array
			
			if ( !Alreadyhated( $post_id ) ) { // hate the post
				update_post_meta( $post_id, "_user_IP", $hated_IPS ); // Add user IP to post meta
				update_post_meta( $post_id, "_post_hate_count", ++$post_hate_count ); // +1 count post meta
				echo $post_hate_count; // update count on front end
				
			} else { // unhate the post
				$ip_key = array_search( $ip, $hated_IPS ); // find the key
				unset( $hated_IPS[$ip_key] ); // remove from array
				update_post_meta( $post_id, "_user_IP", $hated_IPS ); // Remove user IP from post meta
				update_post_meta( $post_id, "_post_hate_count", --$post_hate_count ); // -1 count post meta
				echo "already".$post_hate_count; // update count on front end
				
			}
		}
	}
	
	exit;
}

/**
 * (4) Test if user already hated post
 */
function Alreadyhated( $post_id ) { // test if user hated before
	if ( is_user_logged_in() ) { // user is logged in
		$user_id = get_current_user_id(); // current user
		$meta_USERS = get_post_meta( $post_id, "_user_hated" ); // user ids from post meta
		$hated_USERS = ""; // set up array variable
		
		if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
			$hated_USERS = $meta_USERS[0];
		}
		
		if( !is_array( $hated_USERS ) ) // make array just in case
			$hated_USERS = array();
			
		if ( in_array( $user_id, $hated_USERS ) ) { // True if User ID in array
			return true;
		}
		return false;
		
	} else { // user is anonymous, use IP address for voting
	
		$meta_IPS = get_post_meta( $post_id, "_user_IP" ); // get previously voted IP address
		$ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
		$hated_IPS = ""; // set up array variable
		
		if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
			$hated_IPS = $meta_IPS[0];
		}
		
		if ( !is_array( $hated_IPS ) ) // make array just in case
			$hated_IPS = array();
		
		if ( in_array( $ip, $hated_IPS ) ) { // True is IP in array
			return true;
		}
		return false;
	}
	
}

/**
 * (5) Front end button
 */
function getPosthateLink( $post_id ) {
	$hate_count = get_post_meta( $post_id, "_post_hate_count", true ); // get post hates
	$count = ( empty( $hate_count ) || $hate_count == "0" ) ? '0' : esc_attr( $hate_count );
	if ( Alreadyhated( $post_id ) ) {
		$class = esc_attr( ' hated' );
		$title = esc_attr( 'Unhate' );
		$heart = '<i class="fa fa-heart"></i>';
	} else {
		$class = esc_attr( '' );
		$title = esc_attr( 'hate' );
		$heart = '<i class="fa fa-heart-o"></i>';
	}
	$output = '<a href="#" class="jm-post-hate'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'&nbsp;'.$count.'</a>';
	return $output;
}

/**
 * (6) Retrieve User hates and Show on Profile
 */
add_action( 'show_user_profile', 'show_user_hates' );
add_action( 'edit_user_profile', 'show_user_hates' );
function show_user_hates( $user ) { ?>        
    <table class="form-table">
        <tr>
			<th><label for="user_hates"><?php _e( 'You hate:' ); ?></label></th>
			<td>
            <?php
			$user_hates = get_user_option( "_hated_posts", $user->ID );
			if ( !empty( $user_hates ) && count( $user_hates ) > 0 ) {
				$the_hates = $user_hates;
			} else {
				$the_hates = '';
			}
			if ( !is_array( $the_hates ) )
			$the_hates = array();
			$count = count( $the_hates ); 
			$i=0;
			if ( $count > 0 ) {
				$hate_list = '';
				echo "<p>\n";
				foreach ( $the_hates as $the_hate ) {
					$i++;
					$hate_list .= "<a href=\"" . esc_url( get_permalink( $the_hate ) ) . "\" title=\"" . esc_attr( get_the_title( $the_hate ) ) . "\">" . get_the_title( $the_hate ) . "</a>\n";
					if ($count != $i) $hate_list .= " &middot; ";
					else $hate_list .= "</p>\n";
				}
				echo $hate_list;
			} else {
				echo "<p>" . _e( 'You don\'t hate anything yet.' ) . "</p>\n";
			} ?>
            </td>
		</tr>
    </table>
<?php }

/**
 * (7) Add a shortcode to your posts instead
 * type [jmhater] in your post to output the button
 */
function jm_hate_shortcode() {
	return getPosthateLink( get_the_ID() );
}
add_shortcode('jmhater', 'jm_hate_shortcode');

/**
 * (8) If the user is logged in, output a list of posts that the user hates
 * Markup assumes sidebar/widget usage
 */
function frontEndUserhates() {
	if ( is_user_logged_in() ) { // user is logged in
		$hate_list = '';
		$user_id = get_current_user_id(); // current user
		$user_hates = get_user_option( "_hated_posts", $user_id );
		if ( !empty( $user_hates ) && count( $user_hates ) > 0 ) {
			$the_hates = $user_hates;
		} else {
			$the_hates = '';
		}
		if ( !is_array( $the_hates ) )
			$the_hates = array();
		$count = count( $the_hates );
		if ( $count > 0 ) {
			$limited_hates = array_slice( $the_hates, 0, 5 ); // this will limit the number of posts returned to 5
			$hate_list .= "<aside>\n";
			$hate_list .= "<h3>" . __( 'You hate:' ) . "</h3>\n";
			$hate_list .= "<ul>\n";
			foreach ( $limited_hates as $the_hate ) {
				$hate_list .= "<li><a href='" . esc_url( get_permalink( $the_hate ) ) . "' title='" . esc_attr( get_the_title( $the_hate ) ) . "'>" . get_the_title( $the_hate ) . "</a></li>\n";
			}
			$hate_list .= "</ul>\n";
			$hate_list .= "</aside>\n";
		}
		echo $hate_list;
	}
}

/**
 * (9) Outputs a list of the 5 posts with the most user hates TODAY
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_today() {
	global $post;
	$today = date('j');
  	$year = date('Y');
	$args = array(
		'year' => $year,
		'day' => $today,
		'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
		'meta_query' => array(
			  array(
				  'key' => '_post_hate_count',
				  'value' => '0',
				  'compare' => '>'
			  )
		  ),
		'meta_key' => '_post_hate_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => 5
		);
	$pop_posts = new WP_Query( $args );
	if ( $pop_posts->have_posts() ) {
		echo "<aside>\n";
		echo "<h3>" . _e( 'Today\'s Most Popular Posts' ) . "</h3>\n";
		echo "<ul>\n";
		while ( $pop_posts->have_posts() ) {
			$pop_posts->the_post();
			echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
		}
		echo "</ul>\n";
		echo "</aside>\n";
	}
	wp_reset_postdata();
}

/**
 * (10) Outputs a list of the 5 posts with the most user hates for THIS MONTH
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_month() {
	global $post;
	$month = date('m');
  	$year = date('Y');
	$args = array(
		'year' => $year,
		'monthnum' => $month,
		'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
		'meta_query' => array(
			  array(
				  'key' => '_post_hate_count',
				  'value' => '0',
				  'compare' => '>'
			  )
		  ),
		'meta_key' => '_post_hate_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => 5
		);
	$pop_posts = new WP_Query( $args );
	if ( $pop_posts->have_posts() ) {
		echo "<aside>\n";
		echo "<h3>" . _e( 'This Month\'s Most Popular Posts' ) . "</h3>\n";
		echo "<ul>\n";
		while ( $pop_posts->have_posts() ) {
			$pop_posts->the_post();
			echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
		}
		echo "</ul>\n";
		echo "</aside>\n";
	}
	wp_reset_postdata();
}

/**
 * (11) Outputs a list of the 5 posts with the most user hates for THIS WEEK
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_week() {
	global $post;
	$week = date('W');
  	$year = date('Y');
	$args = array(
		'year' => $year,
		'w' => $week,
		'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
		'meta_query' => array(
			  array(
				  'key' => '_post_hate_count',
				  'value' => '0',
				  'compare' => '>'
			  )
		  ),
		'meta_key' => '_post_hate_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => 5
		);
	$pop_posts = new WP_Query( $args );
	if ( $pop_posts->have_posts() ) {
		echo "<aside>\n";
		echo "<h3>" . _e( 'This Week\'s Most Popular Posts' ) . "</h3>\n";
		echo "<ul>\n";
		while ( $pop_posts->have_posts() ) {
			$pop_posts->the_post();
			echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
		}
		echo "</ul>\n";
		echo "</aside>\n";
	}
	wp_reset_postdata();
}

/**
 * (12) Outputs a list of the 5 posts with the most user hates for ALL TIME
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular() {
	global $post;
	echo "<aside>\n";
	echo "<h3>" . _e( 'Most Popular Posts' ) . "</h3>\n";
	echo "<ul>\n";
	$args = array(
		 'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
		 'meta_query' => array(
			  array(
				  'key' => '_post_hate_count',
				  'value' => '0',
				  'compare' => '>'
			  )
		  ),
		 'meta_key' => '_post_hate_count',
		 'orderby' => 'meta_value_num',
		 'order' => 'DESC',
		 'posts_per_page' => 5 
		 );
	$pop_posts = new WP_Query( $args );
	while ( $pop_posts->have_posts() ) {
		$pop_posts->the_post();
		echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
	}
	wp_reset_postdata();
	echo "</ul>\n";
	echo "</aside>\n";
}
