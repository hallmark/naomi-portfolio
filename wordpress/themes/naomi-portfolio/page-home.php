<?php

//
//  Custom template for Home page
//

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">

  <?php
  //
  //
  //   ADD NEW CAROUSEL ITEMS HERE!!!
  //
  //
  $front_box_post = 37;
  $left_boxes_posts = array(65, 62);
  $right_boxes_posts = array(51, 58);
  
  
  function ntp_home_get_project_thumb_url($post_id) {
    $image_id = get_post_thumbnail_id($post_id);
    $image_src = wp_get_attachment_image_src( $image_id, 'large' );
    return $image_src[0];
  }
  
  function ntp_js_obj_for_post($post_id) {
    $content = '';
    $content .= "{\n";
    $content .= "\t\t'imgSrc': '" . ntp_home_get_project_thumb_url($post_id) . "',\n";
    $content .= "\t\t'title': " . json_encode(get_the_title($post_id)) . ",\n";
    $content .= "\t\t'link': '" . get_permalink($post_id) . "'\n";
    $content .= "\t}";
    return $content;
  }
  
  ?>

      <script type="text/javascript">
        
        /**
         *   JSON for carousel items
         */
        var frontBox = <?php echo ntp_js_obj_for_post($front_box_post); ?>;
        var leftBoxes = [
        <?php
      
        $left_json = array();
        foreach ( $left_boxes_posts as $one_post ) {
          $left_json[] = ntp_js_obj_for_post($one_post);
        }
      
        echo join(",\n\t", $left_json) . "\n";
        ?>
        ];
        var rightBoxes = [
        <?php
      
        $right_json = array();
        foreach ( $right_boxes_posts as $one_post ) {
          $right_json[] = ntp_js_obj_for_post($one_post);
        }
      
        echo join(",\n\t", $right_json) . "\n";
        ?>
        ];
        
        var boxes = leftBoxes.reverse().concat(frontBox, rightBoxes);
        var frontIdx = leftBoxes.length;
        var coverflow = new SplashCoverflow( boxes, frontIdx );
        
        YUI().use('node-base', function(Y) {
             function init() {
               //js_growl.addMessage({msg:'initializing ' + boxes.length + ' items..'});
               //js_growl.addMessage({msg:'CSS Transitions: ' + (support.csstransitions? 'supported':'unsupported')});
               
               coverflow.render();
             }
             Y.on("domready", init);
        });
        
      </script>


		
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
					if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {
						post_class();
						echo '>';
					} else {
						echo 'class="';
						thematic_post_class();
						echo '">';
					}
	                
	                // creating the post header
	                thematic_postheader();
	                
	                ?>
	                
					<div class="entry-content">
					  
					  <!-- CSS for this page -->
					  <style>
					    
					    .slug-home .centered-canvas {
                width: 425px;
                height: 285px;
                margin: 55px auto 0;
                position: relative;
              }
              .slug-home #dummyFrontBox {
                width: 425px;
                height: 285px;
                border: 1px solid white;
                background-color: #71879F;
                margin: 0;
                z-index: 10;
                position: relative;
              }
              .slug-home .box {
                position: absolute;
                margin: 0;
                cursor: pointer;
              }
              .slug-home .box img {
                width: 100%;
                height: 100%;
              }
              .slug-home .front-box {
                width: 425px;
                height: 285px;
                border: 1px solid white;
                background-color: #71879F;
                margin: 0;
                z-index: 10;
                position: relative;
              }
              .slug-home .back-box {
                width: 185px;
                height: 125px;
                border: none;
                position: absolute;
                top: 90px;
                z-index: 1;
              }
              .slug-home .back-box img {
                width: 185px;
                height: 125px;
                z-index: 10;
              }


            </style>
            
                      <div class="centered-canvas" id="stage">
                        <div id="dummyFrontBox"></div>
                      </div>
                      
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