jQuery(document).ready(function($){
    $('.tdm-color-field').wpColorPicker();

    if($('select#select_post_type').val() == 'product'){
        $('.produtc_option').show();
    }

    // select post type chenge
    $('select#select_post_type').on('change', function() {
        if(this.value == 'product' ){
           $('.produtc_option').show();
        }else{
            $('.produtc_option').hide();
        }
      }); 

});