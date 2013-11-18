<?php

//
// Portfolio Project Custom Post Type
//

add_action('init', 'create_project_post_type');

function create_project_post_type() {
  
  // Projects (flat)
  $labels = array(
    'name' => __('Projects'),
    'singular_name' => __('Project Page'),
    'add_new_item' => __('Add New Project Page'),
    'edit_item' => __('Edit Project Page'),
    'view_item' => __('View Project Page')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'menu_position' => 20,
    'hierarchical' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes'),
    'rewrite' => array('slug'=>'portfolio', 'with_front'=>false),
    'taxonomies' => array('category', 'post_tag')
  );
  register_post_type('ntp_project', $args);
}


// Return ordered array of project categories for display in the 'Portfolio'
// page and project sidebar
//
function ntp_get_project_categories() {
  $options = get_option('ntp_theme_options');
  $projectcats = $options['projectcats'];
  $projectcats = str_replace(" ", "", $projectcats);
  return explode(",", $projectcats);
  //return array('documentary', 'video-production', 'exhibits-interactives', 'designs');
}


// Add a dynamic body class for Project pages
//
function ntp_project_dynamic_class($c) {
  if ( get_post_type() === 'ntp_project' ) {
    $c[] = 'cpt-project';
  }
  return $c;
}
add_filter('thematic_body_class', 'ntp_project_dynamic_class');


// Add a dynamic nav menu class for Project pages
//
function ntp_project_nav_class($classes, $item) {
  if ( get_post_type() === 'ntp_project' && $item->title == "Portfolio" ) {
    $classes[] = 'current_page_item';
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'ntp_project_nav_class', 10 , 2);


// Show sidebar for Project pages
//
function ntp_project_showsidebar($show) {
  
  return ( get_post_type() === 'ntp_project' );
  
}
add_filter('thematic_sidebar', 'ntp_project_showsidebar');


// Use project-sidebar.php for sidebar contents of a Project page
//
function ntp_project_sidebar() {
		if ( is_singular() && get_post_type() === 'ntp_project' ) {
      get_template_part('project-sidebar');
    }
}
add_action('thematic_abovemainasides','ntp_project_sidebar',1);



// Use 2-column stylesheet and prettyPhoto CSS for Project pages
//
function ntp_project_stylesheet() {
  if ( get_post_type() === 'ntp_project' ) {
    // Depends on thematic_style because it overrides styles included by style.css.
    wp_enqueue_style('two_col_left_930px', get_stylesheet_directory_uri() . '/styles/2c-l-fixed-930px.css', array('thematic_style'));
    wp_enqueue_style('prettyPhoto_min', get_stylesheet_directory_uri() . '/styles/prettyPhoto-min.css', false, '3.1.5');
  }
}
add_action('wp_enqueue_scripts', 'ntp_project_stylesheet');


// Add JavaScript for Project pages
//
function ntp_project_page_js() {
		if ( is_singular() && get_post_type() === 'ntp_project' ) {
		  wp_enqueue_script('yui-script', '//yui.yahooapis.com/3.2.0/build/yui/yui-min.js', false, '3.2.0');
		  wp_enqueue_script('prototype');
		  wp_enqueue_script('scriptaculous');
		  wp_enqueue_script('portfolio-detail-script', get_stylesheet_directory_uri() . '/js/portfolio-detail.js', array('jquery', 'yui-script', 'prototype'));
		  wp_enqueue_script('prettyphoto-script', get_stylesheet_directory_uri() . '/js/jquery.prettyPhoto-3.0b.js', array('jquery'), '3.1.5');
    }
}
add_action('wp_enqueue_scripts','ntp_project_page_js');


// Don't show post header meta in content area for Project pages
//
function ntp_project_post_header_meta($content) {
  if ( is_singular() && get_post_type() === 'ntp_project' ) {
    return '';
  }
  else {
    return $content;
  }
}
add_filter('thematic_postheader_postmeta', 'ntp_project_post_header_meta');



?>