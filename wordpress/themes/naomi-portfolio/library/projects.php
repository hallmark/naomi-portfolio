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


// Add a dynamic body class for Project pages
//
function ntp_project_dynamic_class($c) {
  if ( get_post_type() === 'ntp_project' ) {
    $c[] = 'cpt-project';
  }
  return $c;
}
add_filter('thematic_body_class', 'ntp_project_dynamic_class');


// Show sidebar for Project pages
//
function ntp_project_showsidebar($show) {
  
  return ( get_post_type() === 'ntp_project' );
  
}
add_filter('thematic_sidebar', 'ntp_project_showsidebar');


// Use 2-column stylesheet for Project pages
//
function ntp_project_stylesheet($content) {
  if ( get_post_type() === 'ntp_project' ) {
    $content .= "\t";
    $content .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
    $content .= get_bloginfo('stylesheet_directory');
    $content .= "/styles/2c-l-fixed-930px.css";
    $content .= "\" />";
    $content .= "\n\n";
  }
  return $content;
}
add_filter('thematic_create_stylesheet', 'ntp_project_stylesheet');


?>