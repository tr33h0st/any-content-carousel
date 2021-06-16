<?php 

 // due colonne nel box 
  
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
       $content .=  '<a style="background-color:'.$button_bg_color.';border-color:'.$button_color_border.';color:'.$button_color.';" class="button btn-bianco" href="'.get_permalink($id_prdotto ).'">'. __('Read more','ecctdm_carousel') .'</a>';
       $content .=  '<a style="background:'.$product_button_bg_color.';border: 1px solid '.$product_button_color_border.';color:'. $product_button_color.';" class="button btn-arancio" href="'.get_site_url().'/?add-to-cart='.$id_prdotto.'">'. __('Add to cart','ecctdm_carousel') .'</a>';
       $content .= ' </div>';
    
    $content .= ' </div>';
     $content .= ' </div>';
       $i++;
    endwhile;
    $content .= ' </div>';

    $content .= '</div >';
    wp_reset_query();
}   