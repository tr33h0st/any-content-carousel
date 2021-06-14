(function($){
    
    $(document).ready(function(){

        /* slik slider inizializzazione */

        // width of container slick-list
        var slick_list_width = $('.tab-content').outerWidth();
       
    
        inziazilizzo_slick_slider(slick_list_width);

         // fix width of item-contenuto
         if (slick_list_width < 350 ){
            $(".item-contenuto").css({"max-width":slick_list_width+"px","height":"740px"});
            $(".container-slide .slick-slide ").css({"margin":"0"});
        }else{
            $(".item-contenuto").css({"max-width":slick_list_width+"px"});
        }

        /* tab title funxtion */

        $('.container-slide #tabs li a:not(:first)').addClass('inactive');
            $('.container-slide .tab-content').hide();
            $('.container-slide .tab-content:first').show();
    
            $('.container-slide #tabs li a').click(function(){
                var t = $(this).attr('id');

               if($(this).hasClass('inactive')){ //this is the start of our condition 
                  $('.container-slide #tabs li a').addClass('inactive');           
                  $(this).removeClass('inactive');
              
                  $('.container-slide .tab-content').hide();
                  $('.container-slide #'+ t + 'C').fadeIn('slow');
                  $('.carosello').slick('setPosition');
               }
              });

              /* Modal */

                // Get the modal
                var modal = document.getElementById("video-Modal");

                // Get the button that opens the modal
                var btn = document.getElementById("play"); 
                //var btn = document.getElementsByClassName("play");
                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal
                /* btn.onclick = function() {
                modal.style.display = "block";
                var video_url = btn.value;

                var iframe = document.getElementById('ifrm');
                iframe.src = video_url;
                console.log('apro modal '+video_url);
                } */

                function reply_click(clicked_id) {
                    modal.style.display = "block";

                    var btn = document.getElementById(clicked_id); 

                    var video_url = btn.value;
                    console.log('apro modal '+video_url);
                    var iframe = document.getElementById('ifrm');
                    iframe.src = video_url;
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                modal.style.display = "none";
                var iframe = document.getElementById('ifrm');
                    iframe.src = '';
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    var iframe = document.getElementById('ifrm');
                    iframe.src = '';
                }
                }


              /********* */
            
    
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
