<?php

//
//  Custom template part for sidebar of a Portfolio Project page
//

$project_categories = array('documentary', 'video-production', 'exhibits-interactives', 'designs');
$first_row_class = ' first';

$page_post_id = get_the_ID();
$cats_for_page = wp_get_post_categories( get_the_ID() );

?>

					  
					  <!-- CSS for this page -->
					  <style>



            </style>
            
	                  <div class="main-aside">
                      <div class="projects-rows" id="projectsRows">

	                    <?php
	                    
	                    foreach ( $project_categories as $one_cat ) {
	                      
	                      $cat_obj = get_category_by_slug( $one_cat );
	                      
	                      // get the category name
	                      $one_cat_name = $cat_obj->name;
	                      
	                      // TODO: see if this category is the active one.  If so, set the 'active' class.
	                      if ( in_array( $cat_obj->cat_ID, $cats_for_page ) ) {
	                        $active_row_class = ' active';
	                      } else {
	                        $active_row_class = '';
	                      }

                        ?>

                        <div class="projects-row<?php echo $first_row_class; ?><?php echo $active_row_class; ?>">
                          <div class="row-hd"><?php echo $one_cat_name; ?></div>
                          <div class="thumbs">

      	                    <?php
      	                    
      	                    // get the projects for one category
      	                    $qargs = array(
      	                      'post_type' => 'ntp_project',
      	                      'cat' => $cat_obj->cat_ID,
      	                      'orderby' => 'menu_order',
      	                      'order' => 'ASC',
      	                      'posts_per_page' => -1
      	                      );
      	                    $my_query = new WP_Query($qargs);
      	                    
                            while ($my_query->have_posts()) {
                              global $post;
                              $my_query->the_post();
                              
                              // TODO: see if this is the active project.  If so, set the 'selected' class.
                              if ( $page_post_id == $post->ID ) {
                                $selected_thumb_class = ' selected';
                              } else {
                                $selected_thumb_class = '';
                              }

                              ?>
                              <div class="thumb<?php echo $selected_thumb_class; ?>">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'nav-img', array('class'=>'') ); ?></a>
                              </div>
        	                    <?php
      	                    
    	                      }

                            ?>

                          </div>
                          <div class="clear">&nbsp;</div>
                        </div>

  	                    <?php
	                      
	                      $first_row_class = '';
	                      
	                    }
	                    
	                    wp_reset_query();

                      ?>
                        
                      </div>  <!-- end #projectsRows -->
                    </div>  <!-- end .main-aside -->
                      
