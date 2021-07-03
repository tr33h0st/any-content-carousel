<?php 

 // Home Page 

         
 $content .= '<ul id="tabs">';
            
 $content .= '<li><a id="tab1"><h2>Progetti realizzati</h2></a></li>';

  $content .= '<li><a id="tab2"><h2>Cosa offriamo</h2></a></li>';

 $content .= '<li><a id="tab3"><h2>Il nostro metodo</h2></a></li>'; 


$content .= '</ul>';

//$page_id = get_queried_object_id();
//$images = get_field('galleria_immagini_home','option');

 // tab progetti

                      
 $progetti = get_posts(array(
    'numberposts'	=> 3,
    'post_type'		=> 'progetto'
 ));
 
 if ( $progetti ) {
    

    $content .= '<div class="tab-content" id="tab1C">';

    $content .= '<div class="card">';
    $content .= ' <div class="slider">';
    
    $i=1;
    foreach ( $progetti as $progetto ){

       $id_progetto = $progetto->ID;
       $post = get_post($id_progetto);
       $post_content = $post->post_content;
    
       $content .= '<div class="item item-contenuto">';
       $content .= '<div class="item-inner">';

       $content .= '<div class="col-sx" style="background-image:url('.get_the_post_thumbnail_url($id_progetto, 'medium').')">';

          // se non c'è il video perendi immagine evidenza
          $iframe = get_field('video_youtube', $id_progetto);
          if ( $iframe != null){
             //$iframe = str_replace('></iframe>', ' width="100%" height="310" frameborder="0"></iframe>', $iframe);
             
          // $content .=  '<img src="'.get_the_post_thumbnail_url($id_progetto, 'full').'" alt="">';
             $content .= '<button id="play_progetto_'.$i.'" onClick="reply_click(this.id)" value="'.$iframe.'" class="play"><img src="'.plugin_dir_url( __FILE__ ) . '/img/play.svg'.'" ></button>';
          }/* else{
             $content .=  '<img src="'.get_the_post_thumbnail_url($id_progetto, 'full').'" alt="">';
          } */
          

       $content .= ' </div>';

       $content .= '<div class="col-dx">';
       $content .= '<h3>'.get_the_title($id_progetto).'</h3>';
       $content .= '<hr>';
       $content .= '<br>';
       $content .=  '<p>'.wp_trim_words( $post_content, 48 ) .'</p>';
       $content .=  '<a class="button btn-bianco" href="'.get_permalink($id_progetto ).'">Continua</a>';
       $content .= ' </div>';
    
       $content .= ' </div>';
       $content .= ' </div>';
       $i++;
       
    } 
    $content .= ' </div>';
    $content .= ' </div>';

    $content .= '</div >';
 
 }    // fine tab Progetti

 // Servizi 
  $servizi = get_posts(array(
    'numberposts'	=> 4,
    'post_type'		=> 'servizi'
  ));
  
  if ( $servizi ) {
    

    $content .= '<div class="tab-content" id="tab2C">';

    $content .= '<div class="card">';
    $content .= ' <div class="slider">';
    
    foreach ( $servizi as $servizio ){

                $id_servizio = $servizio->ID;
                $post = get_post($id_servizio);
                $post_content = $post->post_content;
             
                $content .= '<div class="item item-contenuto">';
                $content .= '<div class="item-inner">';
 
                $content .= '<div class="col-sx" style="background-image:url('.get_field( 'immagine_plugin_servizio',$id_servizio).')">';
          
                  
                //$content .=  '<img src="'.get_field( 'immagine_plugin_servizio',$id_servizio).'" alt="">';
                   
                $content .= ' </div>';
 
                $content .= '<div class="col-dx">';
                $content .= '<h3>'.get_the_title($id_servizio).'</h3>';
                $content .= '<hr>';
                $content .= '<br>';
                $content .=  '<p>'.wp_trim_words( $post_content, 48 ) .'</p>';
                $content .=  '<a class="button btn-bianco" href="'.get_permalink($id_servizio ).'">Continua</a>';
                $content .= ' </div>';
             
                $content .= ' </div>';
                $content .= ' </div>';
                
             } 
             $content .= ' </div>';
             $content .= ' </div>';
 
             $content .= '</div >';
             wp_reset_postdata();
       }    

 // Inizio Tab Metodi

$metodi = get_field('metodi');

$content .= '<div class="tab-content" id="tab3C">';


$size = 'full'; // (thumbnail, medium, large, full or custom size)
if(  $metodi ){

 $content .= '<div class="card">';
 $content .= ' <div class="slider">';
  $i=1;
  foreach(  $metodi as  $metodo ){

             $content .= '<div class="item">';
             $content .= '<div class="item-inner">';

             $content .= '<div class="col-sx" style="background-image:url('.$metodo['immagine'].')">';

             $iframe = $metodo['video'];
             if ($iframe != null){
               // $content .=  '<img src="'.$metodo['immagine'].'" alt="">';
                $content .= '<button id="play_'.$i.'" onClick="reply_click(this.id)" value="'.$iframe.'" class="play"><img src="'.plugin_dir_url( __FILE__ ) . '/img/play.svg'.'" ></button>';
             }/* else{
                $content .=  '<img src="'.$metodo['immagine'].'" alt="">';
             } */
             

          $content .= ' </div>';

          $content .= '<div class="col-dx">';
          $content .= '<h3>'.$metodo['titolo'].'</h3>';
          $content .= '<hr>';
          $content .= '<br>';
          $content .=  '<p>'.$metodo['testo'].'</p>';

          $content .= ' </div>';
          
             $content .= ' </div>';
             $content .= ' </div>';
             $i++;

  }

  $content .= ' </div>';
  $content .= ' </div>';

}
$content .= ' </div>'; // Tab3C fine

wp_reset_postdata();