<?php
/*
Admin Panel Option
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'tdm_ecctdm_Options' ) ) {

	class tdm_ecctdm_Options {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'tdm_ecctdm_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'tdm_ecctdm_Options', 'register_settings' ) );
			}

		}

		/**
		 * Returns all ecctdm options
		 *
		 * @since 1.0.0
		 */
		public static function get_ecctdm_options() {
			return get_option( 'ecctdm_options' );
		}

		/**
		 * Returns single ecctdm option
		 *
		 * @since 1.0.0
		 */
		public static function get_ecctdm_option( $id ) {
			$options = self::get_ecctdm_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Carousel Settings', 'tdm_carousel' ),
				esc_html__( 'Carousel Settings', 'tdm_carousel' ),
				'manage_options',
				'plugin-settings',
				array( 'tdm_ecctdm_Options', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'ecctdm_options', 'ecctdm_options', array( 'tdm_ecctdm_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				// Checkbox
				/* if ( ! empty( $options['checkbox_example'] ) ) {
					$options['checkbox_example'] = 'on';
				} else {
					unset( $options['checkbox_example'] ); // Remove from options if not checked
				} */

				// Input Title 
				if ( ! empty( $options['carousel_title'] ) ) {
					$options['carousel_title'] = sanitize_text_field( $options['carousel_title'] );
				} else {
					unset( $options['carousel_title'] ); // Remove from options if empty
				} 

				// Input button color 
				if ( ! empty( $options['read_more_button_color'] ) ) {
					$options['read_more_button_color'] = sanitize_hex_color( $options['read_more_button_color'] );
				} else {
					unset( $options['read_more_button_color'] ); // Remove from options if empty
				} 
				if ( ! empty( $options['read_more_button_txt_color'] ) ) {
					$options['read_more_button_txt_color'] = sanitize_hex_color( $options['read_more_button_txt_color'] );
				} else {
					unset( $options['read_more_button_txt_color'] ); // Remove from options if empty
				} 
				if ( ! empty( $options['read_more_button_color_border'] ) ) {
					$options['read_more_button_color_border'] = sanitize_hex_color( $options['read_more_button_color_border'] );
				} else {
					unset( $options['read_more_button_color_border'] ); // Remove from options if empty
				}

				// Input number of post in carousel 
				if ( ! empty( $options['post_number'] ) ) {
					$options['post_number'] = sanitize_text_field( $options['post_number'] );
				} else {
					unset( $options['post_number'] ); // Remove from options if empty
				} 
				// Select
				if ( ! empty( $options['select_post_type'] ) ) {
					$options['select_post_type'] = sanitize_text_field( $options['select_post_type'] );
				}
				if ( ! empty( $options['select_category'] ) ) {
					$options['select_category'] = sanitize_text_field( $options['select_category'] );
				}
				// Input button color for product
				if ( ! empty( $options['add_to_cart_button_color'] ) ) {
					$options['add_to_cart_button_color'] = sanitize_hex_color( $options['add_to_cart_button_color'] );
				} else {
					unset( $options['add_to_cart_button_color'] ); // Remove from options if empty
				} 
				if ( ! empty( $options['add_to_cart_button_color_border'] ) ) {
					$options['add_to_cart_button_color_border'] = sanitize_hex_color( $options['add_to_cart_button_color_border'] );
				} else {
					unset( $options['add_to_cart_button_color_border'] ); // Remove from options if empty
				}
				if ( ! empty( $options['add_to_cart_button_txt_color'] ) ) {
					$options['add_to_cart_button_txt_color'] = sanitize_hex_color( $options['add_to_cart_button_txt_color'] );
				} else {
					unset( $options['add_to_cart_button_txt_color'] ); // Remove from options if empty
				}

			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">
                <?php $logo_tdm_url = plugin_dir_url(__FILE__)."img/sfera.png"?>
				<h1><img src="<?php echo esc_url($logo_tdm_url) ?>"><?php esc_html_e( 'Carousel Options', 'tdm_carousel' ); ?></h1>
				<p><?php esc_html_e('Insert shortcode [tdm_contentslider] in page content or wherever you want.', 'tdm_carousel')?></p>

				<form method="post" action="options.php">

					<?php settings_fields( 'ecctdm_options' ); ?>

					<table class="form-table wpex-custom-admin-login-table">

						<?php // Checkbox example ?>
						<!-- <tr valign="top">
							<th scope="row"><?php //esc_html_e( 'Checkbox Example', 'tdm_carousel' ); ?></th>
							<td>
								<?php //$value = self::get_ecctdm_option( 'checkbox_example' ); ?>
								<input type="checkbox" name="ecctdm_options[checkbox_example]" <?php //checked( $value, 'on' ); ?>> <?php esc_html_e( 'Checkbox example description.', 'tdm_carousel' ); ?>
							</td>
						</tr> -->

						<tr valig="top">
						   <th scope="row"><?php esc_html_e('Carousel Title','tdm_carousel') ?></th>
						   <td>
						   <?php $title = self::get_ecctdm_option( 'carousel_title' ); ?>
						   <input type="text" name="ecctdm_options[carousel_title]" value="<?php echo esc_attr( $title) ?>"  />
						   </td>
						</tr>

						<tr valig="top">
						   <th scope="row"><?php esc_html_e('Button Read more background Color','tdm_carousel') ?></th>
						   <td>
						   <?php $read_more_color = self::get_ecctdm_option( 'read_more_button_color' ); 
						         if($read_more_color == null || $read_more_color == ''){
									$read_more_color = "#ffffff";
								}   
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[read_more_button_color]" type="text" value="<?php echo esc_attr( $read_more_color) ?>" data-default-color="#ffffff" />
						   </td>
						</tr>

						<tr valig="top">
						   <th scope="row"><?php esc_html_e('Button Read more Color','tdm_carousel') ?></th>
						   <td>
						   <?php $read_more_txt_color = self::get_ecctdm_option( 'read_more_button_txt_color' ); 
						         if($read_more_txt_color == null || $read_more_txt_color == ''){
									$read_more_txt_color = "#000000";
								}   
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[read_more_button_txt_color]" type="text" value="<?php echo esc_attr( $read_more_txt_color) ?>" data-default-color="#000000" />
						   </td>
						</tr>

						<tr valig="top">
						   <th scope="row"><?php esc_html_e('Button Read more Color Border','tdm_carousel') ?></th>
						   <td>
						   <?php $read_more_border_color = self::get_ecctdm_option( 'read_more_button_color_border' ); 
						         if($read_more_border_color == null || $read_more_border_color == ''){
									$read_more_border_color = "#000000";
								}   
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[read_more_button_color_border]" type="text" value="<?php echo esc_attr( $read_more_border_color) ?>" data-default-color="#000000" />
						   </td>
						</tr>


						<?php // Post number to show ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Number of posts to show', 'tdm_carousel' ); ?></th>
							<td>
								<?php $value = self::get_ecctdm_option( 'post_number' ); ?>
								<input type="number" name="ecctdm_options[post_number]" value="<?php echo esc_attr( $value ); ?>">
							</td>
						</tr>

						<?php // Select Post

                            $args=array(
                                'public'   => true,
                                '_builtin' => false
                                ); 
                           $output = 'names';
                           $operator = 'and';
                           $post_types=get_post_types($args,$output,$operator); 
                        
                        ?>
                       


						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Select post type', 'tdm_carousel' ); ?></th>
							<td>
								<?php $value = self::get_ecctdm_option( 'select_post_type' ); ?>
								<select id="select_post_type" name="ecctdm_options[select_post_type]">
                                <option value=""><?php esc_html_e('Posts','tdm_carousel') ?></option>
								<option value="users" <?php selected( $value, 'users', true ); ?>><?php esc_html_e('Users','tdm_carousel') ?></option>
									<?php
									$options =$post_types;
									foreach ( $options as $id => $label ) { ?>
										<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
							</td>
						</tr>

					  <?php // Category ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Category', 'tdm_carousel' ); ?></th>
							<td>
								<?php $value = self::get_ecctdm_option( 'selected_category' ); ?>
								<select id="selected_category" name="ecctdm_options[selected_category]">
								<option value=""><?php esc_html_e('Category','tdm_carousel') ?></option>
								<?php if($value != null ){ 
									$term = get_term( $value );
									$category_name = $term->name;
									?>
                                 <option value="<?php echo esc_attr( $value ); ?>" selected>
									<?php echo strip_tags( $category_name ); ?>
								</option>
								<?php } ?>
								</select>
							</td>
						</tr>
						<tr class="produtc_option" valig="top" hidden>
						<th scope="row"> <?php  esc_html_e('Product Options','tdm_carousel') ?></th>
						<td><p><?php  esc_html_e('the carousel shows all the products highlighted','tdm_carousel') ?></p></td>
						</tr>

						<tr class="produtc_option" valig="top" hidden>
						   <th scope="row"><?php esc_html_e('Button Add to Cart background Color','tdm_carousel') ?></th>
						   <td>
						   <?php $add_to_cart_color = self::get_ecctdm_option( 'add_to_cart_button_color' ); 
						         if($add_to_cart_color == null || $add_to_cart_color == ''){
									 $add_to_cart_color = "#c4801a";
								 }  
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[add_to_cart_button_color]" type="text" value="<?php echo esc_attr( $add_to_cart_color) ?>" data-default-color="#c4801a" />
						   </td>
						</tr>

						<tr class="produtc_option" valig="top" hidden>
						   <th scope="row"><?php esc_html_e('Button Add to Cart Color','tdm_carousel') ?></th>
						   <td>
						   <?php $add_to_cart_txt_color = self::get_ecctdm_option( 'add_to_cart_button_txt_color' ); 
						         if($add_to_cart_txt_color == null || $add_to_cart_txt_color == ''){
									$add_to_cart_txt_color = "#000000";
								}   
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[add_to_cart_button_txt_color]" type="text" value="<?php echo esc_attr( $add_to_cart_txt_color) ?>" data-default-color="#000000" />
						   </td>
						</tr>

						<tr class="produtc_option" valig="top" hidden>
						   <th scope="row"><?php esc_html_e('Button Add to Cart Color Border','tdm_carousel') ?></th>
						   <td>
						   <?php $add_to_cart_color_border_color = self::get_ecctdm_option( 'add_to_cart_button_color_border' ); 
						        if($add_to_cart_color_border_color == null || $add_to_cart_color_border_color == ''){
									$add_to_cart_color_border_color = "#ffffff";
								}  
						   ?>
						   <input class="tdm-color-field" name="ecctdm_options[add_to_cart_button_color_border]" type="text" value="<?php echo esc_attr( $add_to_cart_color_border_color) ?>" data-default-color="#ffffff" />
						   </td>
						</tr>

					</table>

					<?php submit_button(); ?>

				</form>

			</div><!-- .wrap -->
		<?php }

	}
}
new tdm_ecctdm_Options();

// Helper function to use in your theme to return a theme option value
function get_ecctdm_option( $id = '' ) {
	return tdm_ecctdm_Options::get_ecctdm_option( $id );
}

add_action( 'admin_enqueue_scripts', 'ecctdm_enqueue_color_picker' );
function ecctdm_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'admin-style', plugin_dir_url( __FILE__ ) . '/css/admin-style.css');
    wp_enqueue_script( 'tdm-script-handle', plugins_url('tdm-admin-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}