/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {
	
	$(document).ready(function () {
		if ( typeof($.fn.lazyload) == "function" ) {
			$(".module-scroll-fade").lazyload({
				effect       : "fadeIn"
			});	
		}
	});
	
})(JoomlaShine.jQuery);