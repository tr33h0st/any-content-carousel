<?php
   /**
   * Plugin Name: Any Content Carousel
   * Plugin URI: https://www.treehost.eu/
   * Description: Create Carousels with any post Type
   * Version: 1.0
   * Author: TreeHost
   * Author URI: http://treehost.eu/
   **/


  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* includo stili e script */
function ecctdm_add_scripts() {
   global $post;
     
   //if(has_shortcode( $post->post_content, 'ecctdm_contentslider') && ( is_single() || is_page() ) ){

   wp_enqueue_style( 'slider-style', plugin_dir_url( __FILE__ ) . '/css/slider-style.css');
   wp_enqueue_style( 'slider', plugin_dir_url( __FILE__ ) . '/js/slick-1.8.1/slick.css');
   wp_enqueue_style( 'slider-theme', plugin_dir_url( __FILE__ ) . '/js/slick-1.8.1/slick-theme.css');

   wp_enqueue_script( 'slick-1.8.1', plugin_dir_url( __FILE__ ) . '/js/slick-1.8.1/slick.min.js', array ( 'jquery' ), 1.1, true);
  
   wp_enqueue_script( 'functionjs', plugin_dir_url( __FILE__ ) . '/js/slider-function.js', array ( 'jquery' ), 1.1, true);
  // }

 }
 add_action( 'wp_enqueue_scripts', 'ecctdm_add_scripts' );
 
 // includo file di utitlity
 include('inc/utility.php');
 include('admin/option-panel.php');
 //[contentslider type]
function ecctdm_content_slider_html_render($atts) {

   $a = shortcode_atts( array(
		'type' => '',
   ), $atts );

   /* get option from option page */
   $carousel_title = esc_html(get_ecctdm_option( 'carousel_title' ));
   $post_type = esc_html(get_ecctdm_option( 'select_post_type' ));
   $posts_number = sanitize_option('posts_per_page',get_ecctdm_option( 'post_number' ));
   $button_color = esc_html(get_ecctdm_option('read_more_button_color'));
   $button_color_border = esc_html(get_ecctdm_option('read_more_button_color_border'));
   $product_button_color = esc_html(get_ecctdm_option('add_to_cart_button_color'));
   $product_button_color_border = esc_html(get_ecctdm_option('add_to_cart_button_color_border'));
   

   if ( $a['type'] == ''){
      if ($post_type != null ){
         $tipo_di_post =$post_type;
      }else{
         $tipo_di_post ='post';
      }
      
      }else{
         $tipo_di_post = $a['type'];
      }
   
   if ( $posts_number == 0 || $posts_number == null){
      $posts_number = 5;
   }


   $content = '<div class="container-slide">';

   
   switch ($tipo_di_post) {
      case 'product':
      case 'prodotti':
         // include product type 
         include('inc/content-product.php');
        break;
      case 'users':
         // include home type 
         include('inc/content-user.php');
        break;
      default:
         // include post type 
         include('inc/content-post.php');
    }


   $content .= '</div >';

 
   return  $content;
}
 
 add_shortcode('tdm_contentslider', 'ecctdm_content_slider_html_render');