(function($){
    
    $(document).ready(function(){

        $('.container-slide .tab-content:first').css('opacity','1');

          /* slik slider inizializzazione */

        // width of container slick-list
        var slick_list_width = $('.tab-content').outerWidth();
       
    
        inziazilizzo_slick_slider(slick_list_width);    

         // fix width of item-contenuto
         if (slick_list_width < 769 ){
            $(".item-contenuto").css({"max-width":slick_list_width+"px","height":"auto"});
            $(".container-slide .slick-slide ").css({"margin":"0"});
            // metti with 100% alle colonne dx e sx
            $(".container-slide .item-inner .col-sx").css({"width":"100%","height":"250px"});
            $(".container-slide .item-inner .col-dx").css({"width":"100%","height":"auto"});
            $(".container-slide .item-inner").css({"flex-wrap":"wrap"});
        }else{
            $(".item-contenuto").css({"width":slick_list_width+"px"});
        }

        /* tab title function */

        $('.container-slide .tabs li a:not(:first)').addClass('inactive');
            $('.container-slide .tab-content').hide();
            $('.container-slide .tab-content:first').show();
    
            $('.container-slide .tabs li a').click(function(){
                var t = $(this).attr('id');

               if($(this).hasClass('inactive')){ //this is the start of our condition 
                  $('.container-slide .tabs li a').addClass('inactive');           
                  $(this).removeClass('inactive');
              
                  $('.container-slide .tab-content').hide();
                  $('.container-slide #'+ t + 'C').fadeIn('slow');
                  $('.carosello').slick('setPosition');
               }
              });
   
        });


        function inziazilizzo_slick_slider(slick_list_width){

            if ( slick_list_width <= 577){
                $('.carosello').slick({
                    centerMode: false,
                    slidesToScroll: 1,
                    centerPadding: '20px',
                    speed: 1000,
                    slidesToShow: 1,
                    dots: true,
                    variableWidth: true,
                    infinite: false,
                    arrows: true             
                });

            }else{
                $('.carosello').slick({
                    centerMode: true,
                    slidesToScroll: 1,
                    centerPadding: '20px',
                    speed: 1000,
                    slidesToShow: 1,
                    dots: true,
                    variableWidth: true,
                    infinite: false,
                    responsive: [
                        {
                        breakpoint: 768,
                        settings: {
                            arrows: true,
                            centerMode: true,
                            centerPadding: '20px',
                            slidesToShow: 1
                        }
                        },
                        {
                            breakpoint: 577,
                            settings: {
                                arrows: true,
                                centerMode: false,
                                centerPadding: '20px',
                                slidesToShow: 1
                            }
                            },
                        {
                        breakpoint: 480,
                        settings: {
                            arrows: true,
                            centerMode: false,
                            centerPadding: '20px',
                            slidesToShow: 1
                        }
                        }
                    ]
                });
            }

           

        }


 })(jQuery);
