var s = $( "html" ).scrollTop();
var a = $(".navigation-menu").offset().top;

if ($(window).width() >= 945) { 
	$(document).ready(function(){
		if(s <= 10){   
		   $('.navigation-menu').css({"background-color":"transparent"});
		   $('.navigation-menu').css({"box-shadow":"none"});
		   $('.navigation-menu a.superNav').css({"color":"#1e0033"});
		} else {
		   $('.navigation-menu').css({"background-color":"#3b0066"});
		   $('.navigation-menu').css({"box-shadow":"2px 2px 4px #1a1a1a"});
		   $('.navigation-menu a.superNav').css({"color":"#f3edf8"});
		   $('.navigation-menu a#donate').css({"color":"#1e0033"});
		}
	});

	$(document).scroll(function(){
	if ($(window).width() > 945) {

		if($(this).scrollTop() > 10)
		{   
		   $('.navigation-menu').css({"background-color":"#3b0066"});
		   $('.navigation-menu').css({"transition":"all 0.25s"});
		   $('.navigation-menu').css({"box-shadow":"2px 2px 4px #1a1a1a"});
		   $('.navigation-menu a.superNav').css({"color":"#f3edf8"});
		   $('.navigation-menu a#donate').css({"color":"#1e0033"});
		} else {
		   $('.navigation-menu').css({"background-color":"transparent"});
		   $('.navigation-menu').css({"box-shadow":"none"});
		   $('.navigation-menu a.superNav').css({"color":"#1e0033"});
		}
	}
	});
}

$(window).resize(function(){
	if ($(window).width() < 945) {
			$('.navigation-menu').css({"background-color":"#3b0066"});
			$('.navigation-menu').css({"transition":"left 0.65s"});
			$('.navigation-menu').css({"box-shadow":"2px 2px 4px #1a1a1a"});
			$('.navigation-menu a.superNav').css({"color":"#f3edf8"});
			$('.navigation-menu a#donate').css({"color":"#1e0033"});
		} else {
		document.querySelector('body').classList.remove('OffCanvas-Active');
			//$( "body" ).prepend( "<div>" + $("body,html,document").scrollTop($("#map_canvas").position().top) + "</div>" );
			//to prevent bug in Safari and Chrome
			$("body,html,document").scrollTop($("#map_canvas").position().top);
			if($( "body,html,document" ).scrollTop() <= 10){   
			   $('.navigation-menu').css({"background-color":"transparent"});
			   $('.navigation-menu').css({"box-shadow":"none"});
			   $('.navigation-menu a.superNav').css({"color":"#1e0033"});
			} else {
			   $('.navigation-menu').css({"background-color":"#3b0066"});
			   $('.navigation-menu').css({"transition":"all 0.25s"});
			   $('.navigation-menu').css({"box-shadow":"2px 2px 4px #1a1a1a"});
			   $('.navigation-menu a.superNav').css({"color":"#f3edf8"});
			   $('.navigation-menu a#donate').css({"color":"#1e0033"});
				}
			$(document).scroll(function(){
			if ($(window).width() > 945) {
				if($(this).scrollTop() > 10)
				{   
				   $('.navigation-menu').css({"background-color":"#3b0066"});
				   $('.navigation-menu').css({"transition":"all 0.25s"});
				   $('.navigation-menu').css({"box-shadow":"2px 2px 4px #1a1a1a"});
				   $('.navigation-menu a.superNav').css({"color":"#f3edf8"});
				   $('.navigation-menu a#donate').css({"color":"#1e0033"});
				} else {
				   $('.navigation-menu').css({"background-color":"transparent"});
				   $('.navigation-menu').css({"box-shadow":"none"});
				   $('.navigation-menu a.superNav').css({"color":"#1e0033"});
				}
			}
			});
		}
	});
