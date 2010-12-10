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
function ntp_project_stylesheet($content) {
  if ( get_post_type() === 'ntp_project' ) {
    $content .= "\t";
    $content .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
    $content .= get_bloginfo('stylesheet_directory');
    $content .= "/styles/2c-l-fixed-930px.css";
    $content .= "\" />";
    $content .= "\n\n";
    
    $content .= "\t";
    $content .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
    $content .= get_bloginfo('stylesheet_directory');
    $content .= "/styles/prettyPhoto-min.css";
    $content .= "\" />";
    $content .= "\n\n";
  }
  return $content;
}
add_filter('thematic_create_stylesheet', 'ntp_project_stylesheet');


// Add JavaScript for Project pages
//
function ntp_project_page_js() {
		if ( is_singular() && get_post_type() === 'ntp_project' ) {
	    $scripttag_start = "\t";
	    $scripttag_start .= '<script type="text/javascript" src="';

	    $scriptdir_start = $scripttag_start;
	    $scriptdir_start .= get_bloginfo('stylesheet_directory');
	    $scriptdir_start .= '/js/';
	    
	    $googleapi_start = $scripttag_start;
	    $googleapi_start .= 'http://ajax.googleapis.com/ajax/libs/';
	    
	    $scriptdir_end = '"></script>';
	    
	    $scripts = "\n";
	    $scripts .= $scripttag_start . 'http://yui.yahooapis.com/3.1.1/build/yui/yui-min.js' . $scriptdir_end . "\n";
	    $scripts .= $googleapi_start . 'prototype/1.6/prototype.js' . $scriptdir_end . "\n";
	    $scripts .= $googleapi_start . 'scriptaculous/1.8/scriptaculous.js' . $scriptdir_end . "\n";
	    $scripts .= $scriptdir_start . 'portfolio-detail.js' . $scriptdir_end . "\n";
	    $scripts .= $scriptdir_start . 'jquery-1.3.2.min.js' . $scriptdir_end . "\n";
	    $scripts .= $scriptdir_start . 'jquery.prettyPhoto-3.0b.js' . $scriptdir_end . "\n";
	
    	$scripts .= "\n";
    	$scripts .= "\t";
    	$scripts .= '<script type="text/javascript">' . "\n";
    	$scripts .= "\t\t";
    	$scripts .= '$.noConflict();' . "\n";
    	$scripts .= "\t";
    	$scripts .= '</script>' . "\n";
	
	    // Print script tags
	    print $scripts;
    }
}
add_action('wp_head','ntp_project_page_js');


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