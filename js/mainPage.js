/*послайдовый скроллинг*/

$('.wrapper1').onepage_scroll({
	sectionContainer: "section",
	easing: "ease",
	animationTime: 1000,
	pagination: true,
	updateURL: false,
	loop: false,
	keyboard: true,
	responsiveFallback: false,
	direction: "vertical"
});

/*отображение бургер-меню*/

$('#bm').bind('click', function(e) {
	displayMenu();
});

function displayMenu() {
	$('#bm-block').toggleClass('menu-display');
}

//слайдер картинок

$(document).ready(
function ()
{
	$('.slider-container').slick({
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  centerMode: true,
  variableWidth: true
	});
}
);

//слайдер новостей

$(document).ready(
function ()
{
	$('.news-container').slick();
}
);

//отправка заявки на вступление

$(document).ready(function()
{
$('#form').submit(function(event){
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: new FormData(this),
		contentType: false,
		cache: false,
		processData: false,
		success: function(result)
		{
			$('#form').css('display', 'none');
			$('#success').css('display', 'block');
			$(window).scrollTop(0);
		}
	});

});

});

//увеличение фоток

$(function(){
	$('.mini').click(function(event){
		var img_path = $(this).attr('src');
		$('body').append('<div id="overlay"></div><div id="fullsize"><img src="'+ img_path +'" alt=""><div id="close"></div></div>');
		$('#fullsize').css({
			left: ($(window).width() - $('#fullsize').outerWidth())/2, 
			top:  ($(window).height() - $('#fullsize').outerHeight())/2
		});
		$('#overlay, #fullsize').fadeIn('fast');
	});
	$('body').on('click', '#close, #overlay', function(event)
	{
		event.preventDefault();
		$('#overlay, #fullsize').fadeOut('fast', function()
			{
				$('#close, #fullsize, #overlay').remove();
			});
	});
});

