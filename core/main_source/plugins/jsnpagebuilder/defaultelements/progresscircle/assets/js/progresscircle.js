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
    $(document).ready(function(){
        if(typeof ($.fn.lazyLoad) == 'function'){
            $('.pb-progress-circle').lazyLoad({
                effect: 'fadeIn'
            });
            $('.pb-progress-circle').on('appear', function(){
                if(typeof ($.fn.circliful) == 'function'){
                    var html_content = $(this).html();
                    if(!html_content){
                        $(this).circliful();
                    }
                }
            });
        }else{
            if(typeof ($.fn.circliful) == 'function'){
                $('.pb-progress-circle').circliful();
            }
        }
    });
})(jQuery)