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
