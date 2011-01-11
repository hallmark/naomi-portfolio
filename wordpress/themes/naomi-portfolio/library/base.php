<?php

//
//  Custom Child Theme Functions
//

// I've included a "commented out" sample function below that'll add a home link to your menu
// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
//function childtheme_menu_args($args) {
//    $args = array(
//        'show_home' => 'Home',
//        'sort_column' => 'menu_order',
//        'menu_class' => 'menu',
//        'echo' => true
//    );
//	return $args;
//}
//add_filter('wp_page_menu_args','childtheme_menu_args');

// Unleash the power of Thematic's dynamic classes
// 
define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Unleash the power of Thematic's comment form
//
// define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);

// Unleash the power of Thematic's feed link functions
//
define('THEMATIC_COMPATIBLE_FEEDLINKS', true);

// Use WordPress navigation menus
//
function ntp_use_nav_menu() {
  return 'wp_nav_menu';
}
add_filter('thematic_menu_type', 'ntp_use_nav_menu');


// Don't add an *extra* canonical URL reference
//
function ntp_no_canon() {
  return '';
}
add_filter('thematic_canonical_url', 'ntp_no_canon');


// Additional setup
//
function dont_show_commentsrss() {
  return FALSE;
}
add_filter('thematic_show_commentsrss', 'dont_show_commentsrss');

function dont_show_postthumbs() {
  return FALSE;
}
add_filter('thematic_post_thumbs', 'dont_show_postthumbs');


//
// Add size for 'featured image' header
//
// (Note: also need to add theme support for post-thumbnails because we've set
//  thematic_post_thumbs to FALSE below, and therefore Thematic will no longer
//  add support for post-thumbnails)
//
if ( function_exists( 'add_theme_support') ) {
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'nav-img', 75, 50 ); // Side nav image thumb size
  add_image_size( 'grid-thumb', 150, 100 ); // Thumbnail size on grid listing page
}

// Filter away the default scripts loaded with Thematic
function childtheme_head_scripts() {
 // Abscence makes the heart grow fonder
}
add_filter('thematic_head_scripts','childtheme_head_scripts');

// Stylized title in branding
//
function childtheme_override_blogtitle() { ?>
		
		<div id="blog-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php bloginfo('name') ?>" rel="home"><span class="name">Naomi Ture</span> <span class="portfolio">Portfolio</span></a></span></div>
		
<?php
}
add_action('thematic_header','thematic_blogtitle',3);


// Add a dynamic body class for single blog posts
//
function ntp_blogpost_dynamic_class($c) {
  if ( is_single() && get_post_type() !== 'ntp_project' ) {
    $c[] = 'blog-post';
  }
  return $c;
}
add_filter('thematic_body_class', 'ntp_blogpost_dynamic_class');


// Wrap content with a '#mainContent' div
//
function childtheme_open_maincontent() { ?>
		<div id="mainContent">
<?php
}
add_action('thematic_abovecontainer','childtheme_open_maincontent',1);

function childtheme_close_maincontent() { ?>
		</div>
<?php
}
// THIS IS HACKY, but it should work
add_action('thematic_abovefooter','childtheme_close_maincontent',1);


// Don't show post/page headers in content area
//
//function ntp_post_header($content) {
//  if ( is_singular() ) {
//    return '';
//  }
//  else {
//    return $content;
//  }
//}
// TODO: testing
//add_filter('thematic_postheader', 'ntp_post_header');


// Don't show post/page titles in content area
//
function ntp_custom_post_header_title($content) {
  
  if ( is_page() ) {
    return '';
  }
  else {
    return $content;
  }
}
add_filter('thematic_postheader_posttitle', 'ntp_custom_post_header_title');


// Don't show lots of that junk in the post footer
//
// covers post lists and also single posts
function ntp_post_footer($content) {
  if ( is_home() ) {
    return '';
  }
  elseif ( (is_search() && (get_post_type() === 'post' || get_post_type() === 'ntp_project')) ||
           (is_singular() && (get_post_type() === 'post' || get_post_type() === 'ntp_project'))
         ) {
    if ( current_user_can('edit_posts') ) {
      $postfooter = '<div class="entry-utility">' . thematic_postfooter_posteditlink();
      $postfooter .= "</div><!-- .entry-utility -->\n";
      return $postfooter;
    }
    else {
      return '';
    }
  }
  else {
    return $content;
  }
}
add_filter('thematic_postfooter', 'ntp_post_footer');


// Add JavaScript for Front page
//
function ntp_front_page_js() {
		if ( is_front_page() ) {
	    $scripttag_start = "\t";
	    $scripttag_start .= '<script type="text/javascript" src="';

	    $scriptdir_start = $scripttag_start;
	    $scriptdir_start .= get_bloginfo('stylesheet_directory');
	    $scriptdir_start .= '/js/';
	    
	    $googleapi_start = $scripttag_start;
	    $googleapi_start .= 'http://ajax.googleapis.com/ajax/libs/';
	    
	    $scriptdir_end = '"></script>';
	    
	    $scripts = "\n";
    	$scripts .= "\t";
    	$scripts .= '<script type="text/javascript">' . "\n";
    	$scripts .= "\t\t";
    	$scripts .= 'jQuery.noConflict();' . "\n";
    	$scripts .= "\t";
    	$scripts .= '</script>' . "\n";
    	
	    $scripts .= "\n";
	    $scripts .= $scripttag_start . 'http://yui.yahooapis.com/3.2.0/build/yui/yui-min.js' . $scriptdir_end . "\n";
	    $scripts .= $googleapi_start . 'prototype/1.6/prototype.js' . $scriptdir_end . "\n";
	    $scripts .= $googleapi_start . 'scriptaculous/1.8/scriptaculous.js' . $scriptdir_end . "\n";
	    $scripts .= $scriptdir_start . 'fringe.js' . $scriptdir_end . "\n";
	    $scripts .= $scriptdir_start . 'splash-coverflow.js' . $scriptdir_end . "\n";
	
	    // Print script tags
	    print $scripts;
    }
}
add_action('wp_head','ntp_front_page_js');




?>