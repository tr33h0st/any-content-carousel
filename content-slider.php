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
  
   wp_enqueue_script( 'fslightboxjs', plugin_dir_url( __FILE__ ) . '/js/fslightbox.js', array ( 'jquery' ), 1.1, true);
   wp_enqueue_script( 'functionjs', plugin_dir_url( __FILE__ ) . '/js/slider-function.js', array ( 'jquery' ), 1.1, true);
  // }

 }
 add_action( 'wp_enqueue_scripts', 'ecctdm_add_scripts' );
 
 // includo file di utitlity
 include('inc/utility.php');
 include('admin/option-panel.php');
 //[tdm_contentslider type]
function ecctdm_content_slider_html_render($atts) {

   $a = shortcode_atts( array(
		'type' => '',
   ), $atts );

   /* get option from option page */
   $carousel_title = esc_html(get_ecctdm_option( 'carousel_title' ));
   $post_type = esc_html(get_ecctdm_option( 'select_post_type' ));
   $posts_number = sanitize_option('posts_per_page',get_ecctdm_option( 'post_number' ));
   $button_bg_color = esc_html(get_ecctdm_option('read_more_button_color'));
   $button_color = esc_html(get_ecctdm_option('read_more_button_txt_color'));
   $button_color_border = esc_html(get_ecctdm_option('read_more_button_color_border'));
   $product_button_bg_color = esc_html(get_ecctdm_option('add_to_cart_button_color'));
   $product_button_color = esc_html(get_ecctdm_option('add_to_cart_button_txt_color'));
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
          /* Product post type */
          ob_start();
            $meta_query  = WC()->query->get_meta_query();
            $tax_query   = WC()->query->get_tax_query();
            
            $tax_query[] = array(
               'taxonomy' => 'product_visibility',
               'field'    => 'name',
               'terms'    => 'featured',
               'operator' => 'IN',
            );

            $args = array(
               'post_type'           => 'product',
               'post_status'         => 'publish',
               'ignore_sticky_posts' => 1,
               'posts_per_page'      => $posts_number,
               'orderby'             => 'date',
               'order'               => 'ASC',
               'meta_query'          => $meta_query,
               'tax_query'           => $tax_query,
            );
            $prdotti = new WP_Query( $args ); 

         $prdotti = apply_filters('ecctdm_carousel_product_query', $prdotti, $args); 

         // include product type 
         include('inc/content-product.php');
        break;
      case 'users':
         /* Users */
         $args = array(
            'role__not_in'   => array('subscriber','contributor'),
            'order' => 'ASC', 
            'number'=>$posts_number, 
            'has_published_posts'=> true
        );
        $users = get_users( $args );

        $users = apply_filters('ecctdm_carousel_user_query', $users, $args); 
         // include user post type  
         include('inc/content-user.php');
        break;
      default:
         /* Post Type */
         $args = array(
               'post_type' => $tipo_di_post,
               'orderby'   => 'date',
               'order' => 'DESC', 
               'posts_per_page'=>$posts_number, 
         );
         $posts = get_posts( $args );     

         // apply filter to modify posts query result
         $posts = apply_filters('ecctdm_carousel_posts_query', $posts, $tipo_di_post); 

         // include post type 
         include('inc/content-post.php');
    }


   $content .= '</div >';

 
   return  $content;
}
 
 add_shortcode('tdm_contentslider', 'ecctdm_content_slider_html_render');

  /* Set panel for pst format */

  function tdm_post_formats_setup() {

   add_theme_support( 'post-formats', array('gallery','quote','video','aside','image', 'link','status','audio','chat') );
   
   }
   
   add_action( 'after_setup_theme', 'tdm_post_formats_setup' );