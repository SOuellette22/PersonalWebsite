(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away

		$("#gameForm").on("submit", function(e){
			e.preventDefault();
			let game = $("#game");
			window.location.href = game.val();

		})
		
		
	});
	
})(jQuery, this);
