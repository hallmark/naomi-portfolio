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
function childtheme_remove_scripts(){
 remove_action('wp_enqueue_scripts','thematic_head_scripts');
}
add_action('init','childtheme_remove_scripts');

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


// Add a dynamic nav menu class for single blog posts
//
function ntp_blogpost_nav_class($classes, $item) {
  if ( is_single() && get_post_type() !== 'ntp_project' && $item->title == "Blog" ) {
    $classes[] = 'current_page_item';
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'ntp_blogpost_nav_class', 10 , 2);


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
		  wp_enqueue_script('yui-script', '//yui.yahooapis.com/3.2.0/build/yui/yui-min.js', false, '3.2.0');
		  wp_enqueue_script('prototype');
		  wp_enqueue_script('scriptaculous-effects');
		  wp_enqueue_script('fringe-script', get_stylesheet_directory_uri() . '/js/fringe.js', array('prototype'));
		  wp_enqueue_script('splash-coverflow-script', get_stylesheet_directory_uri() . '/js/splash-coverflow.js', array('prototype', 'scriptaculous-effects', 'fringe-script'));
    }
}
add_action('wp_enqueue_scripts','ntp_front_page_js');




?>