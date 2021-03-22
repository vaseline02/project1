$(document).ready(function() {
	
    $(window).on('scroll',function(e){
    	parallax();

    });
    
});
function parallax(){
	var scrolled = $(window).scrollTop();
	$('#px-bg1').css('top',(($(window).height())-(scrolled*.25))+'px');
	$('#px-bg2').css('top',(($(window).height())-(scrolled*.5))+'px');
	$('#px-bg3').css('top',(($(window).height())-(scrolled*.75))+'px');
}

