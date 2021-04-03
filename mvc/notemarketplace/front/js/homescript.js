$(function(){
    
    showHideNav();
   $(window).scroll(function(){
       showHideNav();
   }); 
    function showHideNav(){
       if($(window).scrollTop()>50){
          //show white
          $("#home-nav").addClass("white-nav-top"); 
           //dark logo
           $(".navbar-home img").attr("src", "images/images/logo.png");
		   $('.navbar-home-li li a').css("color","#000");
    $('#button-nav p').css("color","#fff").css("background-color","#6255a5");
          }else{
          $("#home-nav").removeClass("white-nav-top").addClass("navbar"); 
           $(".navbar-home img").attr("src", "images/images/top-logo.png");
$('.navbar-home-li li a').css("color","#fff");
			     $('#button-nav p').css("color","#6255a5").css("background-color","#fff");;
			  
          } 
    }
});
