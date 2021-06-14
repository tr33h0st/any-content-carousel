<?php 

// due colonne nel box 
$args = array(
    'post_type' => $tipo_di_post,
    'orderby'   => 'date',
    'order' => 'DESC', 
    'posts_per_page'=>$posts_number, 
);
$posts = get_posts( $args );

if ( $posts ) {
   
   $content .= '<ul id="tabs" >';

   if ($carousel_title != null || $carousel_title !=''){
      $content .= '<li><a id="tab1"><h2>'.$carousel_title.'</h2></a></li>';
   }else{
      $content .= '<li><a id="tab1"><h2>'.__('Latest from the Blog','ecctdm_carousel').'</h2></a></li>';
   }

  $content .= '</ul>';

   $content .= '<div class="tab-content " id="tab1C">';

   $content .= ' <div class="carosello">';
   $i=1;
   foreach ( $posts as $post ){

      $id_post = esc_attr($post->ID);
      $author_id=esc_attr($post->post_author);
      $author = get_user_by( 'id', $author_id );
      $author_name = esc_attr($author->user_login);
      $category = get_the_category($id_post);
      $post_date =get_the_date( 'D j M' );
      $thumnail_url = esc_url(get_the_post_thumbnail_url( $id_post, 'full' ));
      if ($thumnail_url == null){
         $thumnail_url = esc_url(plugin_dir_url(__FILE__) .'../img/user_no_photo.jpg');
      }

      $content .= '<div class="item item-contenuto">';
      $content .= '<div class="item-inner">';

      $content .= '<div class="col-sx" style="background-image:url('.$thumnail_url.')">';
         

      $content .= ' </div>';

      $content .= '<div class="col-dx">';
      $content .= '<h3>'.esc_html(get_the_title($id_post)).'</h3>';
      $content .=   'By '.$author_name.' on '. $post_date.' in '.$category[0]->name;
      $content .=  '<hr>';
      $content .=  '<p>'.wp_kses_post(ecctdm_exerpt_content($post->post_content,150)).'</p>';
      $content .=  '<a style="background:'.$button_color.';border: 1px solid '.$button_color_border.';color:'.$button_color_border.';" class="button btn-bianco" href="'.get_permalink($id_post ).'">'. __('Read more','ecctdm_carousel') .'</a>';
      $content .= ' </div>';
   
   $content .= ' </div>';
    $content .= ' </div>';
      $i++;
    }
   $content .= ' </div>';

   $content .= '</div >';
   wp_reset_postdata();
}   