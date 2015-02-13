/**
 * @version    $Id$
 * @package    JSN_PageBuilder
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
(function ($) {

	$(document).ready(function () {

		$('[data-original-title]').tooltip({
			placement: 'bottom'
		});
		$(".pb-prtbl-button-fancy").fancybox({
			"width"        : "75%",
			"height"       : "75%",
			"autoScale"    : false,
			"transitionIn" : "elastic",
			"transitionOut": "elastic",
			"type"         : "iframe"
		});
	});

})(jQuery);