<?php 

// due colonne nel box 

if ( $users ) {
   
   $content .= '<ul id="tabs" >';

   if ($carousel_title != null || $carousel_title !=''){
      $content .= '<li><a id="tab1"><h2>'.$carousel_title.'</h2></a></li>';
   }else{
      $content .= '<li><a id="tab1"><h2>'.__('Author','ecctdm_carousel').'</h2></a></li>';
   }

   


  $content .= '</ul>';

   $content .= '<div class="tab-content " id="tab1C">';

   $content .= ' <div class="carosello">';
   $i=1;
   foreach ( $users as $user ){

      $user_id = esc_attr($user->ID);
      $user_name = esc_attr($user->user_firstname).' '.esc_attr($user->user_lastname);
      $user_email = esc_attr($user->user_email);

      $content .= '<div class="item item-contenuto">';
      $content .= '<div class="item-inner">';

      $content .= '<div class="col-sx" >';
      $content .= '<div class="avatar-image" style="background-image:url('.esc_url(get_avatar_url( $user_id, 'medium' )).')"></div>';

      $content .= ' </div>';

      $content .= '<div class="col-dx">';
      $content .= '<h3>'.$user_name.'</h3>';
      $content .= '<span>'.$user_email.'</span>';
      $content .=  '<hr>';
      $content .=  '<p>'.wp_kses_post(wp_trim_words(get_user_meta($user_id, 'description', true),45)).'</p>';
      $content .=  '<a style="background:'.$button_bg_color.';border: 1px solid '.$button_color_border.';color:'.$button_color.';" class="button btn-bianco" href="'.get_author_posts_url( $user_id ).'">'. __('Read more','ecctdm_carousel') .'</a>';
      $content .= ' </div>';
   
   $content .= ' </div>';
    $content .= ' </div>';
      $i++;
    }
   $content .= ' </div>';

   $content .= '</div >';
   wp_reset_postdata();
}   