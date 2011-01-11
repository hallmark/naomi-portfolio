<?php

//
// Theme Options
// from: http://themeshaper.com/sample-theme-options/
//

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'ntp_options', 'ntp_theme_options', 'ntp_theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Portfolio Options' ), __( 'Portfolio Options' ), 'edit_theme_options', 'theme_options', 'ntp_theme_options_do_page' );
}


/**
 * Create the options page
 */
function ntp_theme_options_do_page() {

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'ntp_options' ); ?>
			<?php $options = get_option( 'ntp_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * Text input option for Project Categories
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Project Categories' ); ?></th>
					<td>
						<textarea id="ntp_theme_options[projectcats]" class="large-text" cols="50" rows="3" name="ntp_theme_options[projectcats]"><?php echo stripslashes( $options['projectcats'] ); ?></textarea>
						<label class="description" for="ntp_theme_options[projectcats]"><?php _e( 'Comma-separated list of categories to display in Portfolio page and in the project page sidebar.' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function ntp_theme_options_validate( $input ) {

	// Say our text option must be safe text with no HTML tags
	$input['projectcats'] = wp_filter_nohtml_kses( $input['projectcats'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/