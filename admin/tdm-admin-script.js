jQuery(document).ready(function($){
    $('.tdm-color-field').wpColorPicker();

    if($('select#select_post_type').val() == 'product'){
        $('.produtc_option').show();
    }

    fill_select_category($('select#select_post_type').val());

    // select post type chenge
    $('select#select_post_type').on('change', function() {
        if(this.value == 'product' ){
           $('.produtc_option').show();
        }else{
            $('.produtc_option').hide();
        }

        fill_select_category(this.value);

      }); 

      // get category by post type
      function fill_select_category(post_type){
        $('select#selected_category').prop('disabled', 'disabled');

        if (post_type == 'users' ){
          $('select#selected_category').html('');
          $('select#selected_category').append('<option value="" >Catgory</option>');
        }else{
          $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'tdm_get_terms_by_post_type',
                post_type: post_type,
            },
            success: function (response) {
             var jsonData = JSON.parse(response);

                if(jsonData != null ){   
                  $('#selected_category option').not(':eq(0), :selected').remove();
                  $.each(jsonData, function( index, value ) {
                    if ($('select#selected_category').find("option[value='" + value['term_id'] + "']").length == 0) {
                      $('select#selected_category').append('<option value="'+value['term_id']+'" >'+value['name']+'</option>')
                    }
                  }); 
                  $('select#selected_category').prop('disabled', false);
                }else{
                  $('select#selected_category').html('');
                  $('select#selected_category').append('<option value="" >Category</option>');
                  
                }
            
            },
            error: function (response) {
                console.log(response);
            }
        });
        }
 
      }

});