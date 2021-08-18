<?php 

/**
* Get a limited part of the content - sans html tags and shortcodes - 
* according to the amount written in $limit. Make sure words aren't cut in the middle
* @param int $limit - number of characters
* @return string - the shortened content
*/
function ecctdm_exerpt_content($content,$limit) {
    
    /* sometimes there are <p> tags that separate the words, and when the tags are removed, 
    * words from adjoining paragraphs stick together.
    * so replace the end <p> tags with space, to ensure unstickinees of words */
    $content = strip_tags($content);
    $content = strip_shortcodes($content);
    $content = trim(preg_replace('/\s+/', ' ', $content));
    $ret = $content; /* if the limit is more than the length, this will be returned */
    if (mb_strlen($content) >= $limit) {
       $ret = mb_substr($content, 0, $limit);
       // make sure not to cut the words in the middle:
       // 1. first check if the substring already ends with a space
       if (mb_substr($ret, -1) !== ' ') {
          // 2. If it doesn't, find the last space before the end of the string
          $space_pos_in_substr = mb_strrpos($ret, ' ');
          // 3. then find the next space after the end of the string(using the original string)
          $space_pos_in_content = mb_strpos($content, ' ', $limit);
          // 4. now compare the distance of each space position from the limit
         // if ($space_pos_in_content != false && $space_pos_in_content - $limit <= $limit - $space_pos_in_substr) {
             /* if the closest space is in the original string, take the substring from there*/
           //  $ret = mb_substr($content, 0, $space_pos_in_content);
         // } else {
             // else take the substring from the original string, but with the earlier (space) position
         //    $ret = mb_substr($content, 0, $space_pos_in_substr);
         // }
       }
    }
    return $ret . '...';
 }

 // Add figure type to media type in get_media_embedded_in_content()
 add_filter( 'media_embedded_in_content_allowed_types', function( $types )
{
    array_push($types, 'figure');

    return $types;
} );

/* Get taxonomy by custom post type  */

function tdm_get_terms_by_post_type( $postType = 'post', $taxonomy = 'category'){
    
  /**
   * @param postType default 'post'
   * @param taxonomy default 'category'
   * 
   * @return array of terms for a given $posttype and $taxonomy
   * @since 1.0.1
   * 
   * 1. Get all posts by post type
   * 2. Loop through the posts array and retrieve the terms attached to those posts
   * 3. Store the new terms objects within `$post_terms`
   * 4. loop through `$post_terms` as it's a array of term objects.
   * 5. store the terms with our desired key, value pair inside `$post_terms_array`
   */

  $postType = (isset($_REQUEST['post_type']) ) ? $_REQUEST['post_type'] : 'post';

  if($postType == 'product'){
    $taxonomy = 'product_cat';
  }
  //1. Get all posts by post type
  $get_all_posts = get_posts( array(
      'post_type'     => esc_attr( $postType ),
      'post_status'   => 'publish',
      'numberposts'   => -1
  ) );

  if( !empty( $get_all_posts ) ){

      //First Empty Array to store the terms
      $post_terms = array();
      
      //2. Loop through the posts array and retrieve the terms attached to those posts
      foreach( $get_all_posts as $all_posts ){

          /**
           * 3. Store the new terms objects within `$post_terms`
           */
          $post_terms[] = get_the_terms( $all_posts->ID, esc_attr( $taxonomy ) );

      }

      //Second Empty Array to store final term data in key, value pair
      $post_terms_array = array();

      /**
       * 4. loop through `$post_terms` as it's a array of term objects.
       */

      foreach($post_terms as $new_arr){
          foreach($new_arr as $arr){

              /**
               * 5. store the terms with our desired key, value pair inside `$post_terms_array`
               */
              $post_terms_array[] = array(
                  'name'      => $arr->name,
                  'term_id'   => $arr->term_id,
                  'slug'      => $arr->slug,
                  'url'       => get_term_link( $arr->term_id )
              );
          }
      }

      //6. Make that array unique as duplicate entries can be there
      $terms = array_unique($post_terms_array, SORT_REGULAR);

      //7. Return the final array
      //return $terms;
      echo json_encode( $terms);
      // Don't forget to always exit in the ajax function.
      exit();
  }

}

add_action('wp_ajax_tdm_get_terms_by_post_type', 'tdm_get_terms_by_post_type');
/********* */