<?php

//
//  Custom template for Portfolio Projects grid listing page
//

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">
		
			<?php thematic_abovecontent(); ?>
		
			<div id="content">
	
	            <?php
	        
	            // calling the widget area 'page-top'
	            get_sidebar('page-top');
	
	            the_post();
	            
	            thematic_abovepost();
	        
	            ?>
	            
				<div id="post-<?php the_ID();
					echo '" ';
						post_class();
						echo '>';
	                
	                // creating the post header
	                thematic_postheader();
	                
	                ?>
	                
					<div class="entry-content">
					  
					  <!-- CSS for this page -->
					  <style>



            </style>
            
	
	                    <?php
	                    
                      $project_categories = ntp_get_project_categories();
                      $first_row_class = ' first';
                      
                      ?>
                      
                      <div class="projects-rows">

	                    <?php
	                    
	                    foreach ( $project_categories as $one_cat ) {
	                      
	                      $cat_obj = get_category_by_slug( $one_cat );
	                      
	                      // get the category name
	                      $one_cat_name = $cat_obj->name;

                        ?>

                        <div class="projects-row<?php echo $first_row_class; ?>">
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
                              $my_query->the_post();

                              ?>
                              <div class="thumb">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'grid-thumb', array('class'=>'') ); ?></a>
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
                        
                      </div>
                      <div class="clear" style="height: 30px;">&nbsp;</div>
                      
                      <?php
                      
                      // Don't show content, page links, or the edit link!
                      	                    
	                    //the_content();
	                    
	                    //wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number');
	                    
	                    //edit_post_link(__('Edit', 'thematic'),'<span class="edit-link">','</span>') ?>
	
					</div><!-- .entry-content -->
				</div><!-- #post -->
	
	        <?php
	        
	        thematic_belowpost();
	        
	        
	        // calling the widget area 'page-bottom'
	        get_sidebar('page-bottom');
	        
	        ?>
	
			</div><!-- #content -->
			
			<?php thematic_belowcontent(); ?> 
			
		</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    thematic_sidebar();
    
    // calling footer.php
    get_footer();

?>