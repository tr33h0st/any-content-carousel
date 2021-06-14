<?php 

 // due colonne nel box 
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
  
 if ( $prdotti ) {
    
    $content .= '<ul id="tabs" >';

   if ($carousel_title != null || $carousel_title !=''){
      $content .= '<li><a id="tab1"><h2>'.$carousel_title.'</h2></a></li>';
   }else{
      $content .= '<li><a id="tab1"><h2>'.__('Featured products','ecctdm_carousel').'</h2></a></li>';
   }

   $content .= '</ul>';

    $content .= '<div class="tab-content " id="tab1C">';

    $content .= ' <div class="carosello">';
    $i=1;
    while ( $prdotti->have_posts() ) : $prdotti->the_post(); 

       $id_prdotto = esc_attr($prdotti->post->ID);
       $product = wc_get_product( $id_prdotto );
       if( $product->is_on_sale() ) {
          $thePrice = '<del>'.$product->get_regular_price().' '.get_woocommerce_currency_symbol().'</del> <span>'.$product->get_sale_price().' '.get_woocommerce_currency_symbol().'</span>';
       }else{
          $thePrice = '<span>'.$product->get_regular_price().' '.get_woocommerce_currency_symbol().'</span>';
       }

       $content .= '<div class="item item-contenuto">';
       $content .= '<div class="item-inner">';

       $content .= '<div class="col-sx" style="background-image:url('.esc_url(get_the_post_thumbnail_url( $id_prdotto, 'full' )).')">';
          

       $content .= ' </div>';

       $content .= '<div class="col-dx">';
       $content .= '<h3>'.esc_html(get_the_title($id_prdotto)).'</h3>';
       $content .=   $thePrice;
       $content .=  '<p>'.apply_filters( 'the_content', wp_kses_post(wp_trim_words( get_the_content(), 10 ) )).'</p>';
       $content .=  '<a style="background-color:'.$button_color.';border-color:'.$button_color_border.';color:'.$button_color_border.';" class="button btn-bianco" href="'.get_permalink($id_prdotto ).'">'. __('Read more','ecctdm_carousel') .'</a>';
       $content .=  '<a style="background:'.$product_button_color.';border: 1px solid '.$product_button_color_border.';color:'.$product_button_color_border.';" class="button btn-arancio" href="'.get_site_url().'/?add-to-cart='.$id_prdotto.'">'. __('Add to cart','ecctdm_carousel') .'</a>';
       $content .= ' </div>';
    
    $content .= ' </div>';
     $content .= ' </div>';
       $i++;
    endwhile;
    $content .= ' </div>';

    $content .= '</div >';
    wp_reset_query();
}   