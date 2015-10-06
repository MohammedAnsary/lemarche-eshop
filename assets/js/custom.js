
$( document ).ready(function(){
	var icon = Raphael('bars', 80, 75);
	var b1 = icon.path('M20 25L60 25');
	b1.attr('stroke', '#fff');
  b1.attr('stroke-width', '3');
	var b2 = icon.path('M20 37.5L60 37.5');
	b2.attr('stroke', '#fff');
  b2.attr('stroke-width', '3');
	var b3 = icon.path('M20 50L60 50');
	b3.attr('stroke', '#fff');
  b3.attr('stroke-width', '3');

	$('#bars').click(function() {
		if($(this).hasClass('off')) {
			b1.animate({path: 'M25 25L55 50'},200);
			b2.animate({path: 'M25 25L55 50'},200);
			b3.animate({path: 'M25 50L55 25'},200);
			$(this).removeClass('off');
			$(this).addClass('on');
			$('.menu').addClass('active');
		} else {
			b1.animate({path: 'M20 25L60 25'},200);
			b2.animate({path: 'M20 37.5L60 37.5'},200);
			b3.animate({path: 'M20 50L60 50'},200);
			$(this).removeClass('on');
			$(this).addClass('off');
			$('.menu').removeClass('active');
		}

	});
});
