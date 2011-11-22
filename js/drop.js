// JavaScript Document
$(document).ready(function() {

	// Toggle the dropdown menu's
	$(".dropdown .button, .dropdown button").click(function () {
		if (!$(this).find('span.toggle').hasClass('active')) {
			$('.dropdown-slider').slideUp();
			$('span.toggle').removeClass('active');
		}

// open selected dropown
		$(this).parent().find('.dropdown-slider').slideToggle('fast');
		$(this).find('span.toggle').toggleClass('active');
		
		return false;
	});
	
	// Launch TipTip tooltip
	$('.tiptip a.button, .tiptip button').tipTip();

});

// Close open dropdown slider by clicking elsewhwere on page
$(document).bind('click', function (e) {
	if (e.target.id != $('.dropdown').attr('class')) {
		$('.dropdown-slider').slideUp();
		$('span.toggle').removeClass('active');
	}
});
