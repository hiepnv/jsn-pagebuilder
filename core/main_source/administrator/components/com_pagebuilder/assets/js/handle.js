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

var addedElementContainer;
var isAddNewElement;
//var JSNPBParentModal;
(function ($) {
    $.HandleElement = $.HandleElement || {};
    $.PbDoing = $.PbDoing || {};

    $.HandleElement.initAddElement = function () {
        // Set column where Add element button is clicked
        $("#form-container").on('jsnpb-add-more-element-click', function (event, obj) {
            addedElementContainer = $(obj).closest('.jsn-column').find('.jsn-element-container');
        });

        $('.shortcode-item').on('click', function (e) {
            e.preventDefault();
            if ($.PbDoing.addElement)
                return;
            $.PbDoing.addElement = 1;
            var shortcodeName = $(this).closest('li.jsn-item').attr('data-value');
            // remove spaces between
            shortcodeName = shortcodeName.replace(' ', '');
            $("#pb-add-element").dialog("close");
            isAddNewElement = true;
            var modalTitle = $(this).closest('.jsn-item').attr('data-modal-title');
            $.HandleElement._showSettingModal(shortcodeName, false, false, modalTitle, $(this));

        });

    };

    /**
     * Method to init event to Edit Element button
     */
    $.HandleElement.initEditElement = function () {
        $("#form-container").delegate(".element-edit", "click", function (e, restart_edit) {
            $.HandleElement.showLoading();
            if ($.PbDoing.editElement)
                return;
            $.PbDoing.editElement = 1;
            // Get parameters of edited element.
            var shortcodeContenObj = $(this).closest('.jsn-item').find('[name="shortcode_content[]"]');
            var params = shortcodeContenObj.val();
            var shortcodeName = shortcodeContenObj.attr('shortcode-name');
            addedElementContainer = $(this).closest('.jsn-item');
            var modalTitle = '';
            if ($(this).closest('.jsn-item').attr('data-name')) {
                modalTitle = $(this).closest('.jsn-item').attr('data-name');
            }
            if (typeof( shortcodeName ) == 'undefined' && $(this).attr('data-shortcode') != '') {
                shortcodeName = $(this).attr('data-shortcode');
                params = $(this).closest('.jsn-row-container').find('[name="shortcode_content[]"]').first().text();
            }
            $.HandleElement.editElement(shortcodeName, params, modalTitle, $(this));

            // Trigger progressbar
            $('#param-progress_bar_style').trigger('change');
        });
        // Add action edit element directly on layout page without click edit element icon.
        $("#form-container").on('click', '.item-container-content .jsn-element', function (e, restart_edit) {
            e.stopPropagation();

            // Prevent trigger edit element when click jsn-iconbar collections
            if ($(e.target).closest('.jsn-iconbar').length || $(e.target).hasClass('element-drag')) {
                return false;
            }
            $(this).find('.jsn-iconbar .element-edit').trigger('click');
        });
    }

    $.HandleElement.enableProcessing = function () {
        window.parent.jQuery.noConflict()('body').addClass('jsn_processing');
    }

    $.HandleElement.disableProcessing = function () {
        window.parent.jQuery.noConflict()('body').removeClass('jsn_processing');
    }

    /**
     * Method to process params before opening setting popup
     */
    $.HandleElement.editElement = function (shortcodeName, params, modalTitle, _this, isAdd) {
        params = JSON.stringify(params);
        $.post(
            JSNPbParams.rootUrl + 'administrator/index.php?option=com_pagebuilder&task=shortcode.savesession&tmpl=component&shortcode=' + shortcodeName,
            {
                params: params,
                shortcode: shortcodeName
            },
            function (data) {
                isAddNewElement = false;
                var isEdit = (isAdd == true) ? false : true;

                if (shortcodeName.search('_item') > 0) {
                    $.HandleElement._showSettingModal(shortcodeName, true, isEdit, modalTitle, _this);
                } else {
                    $.HandleElement._showSettingModal(shortcodeName, false, isEdit, modalTitle, _this);
                }
            }
        );
    }

    /**
     * Open setting Modal
     * This modal is used for subelements also
     */
    $.HandleElement._showSettingModal = function (shortcodeName, isSubmodal, isEdit, modalTitle, _this) {
        if (typeof( shortcodeName ) == 'undefined')
            return;
        // count element items.
        var count = 0;
        if (isEdit === false) {
            $('.jsn-item textarea[shortcode-name="' + shortcodeName + '"]').each(function () {
                count++;
            });
        }
        //if (!isSubmodal) {
        $.HandleElement.showLoading();
        //}
        var modalW, modalH;
        //modalW = (parent.document.body.clientWidth > 800) ? 800 : parent.document.body.clientWidth*0.9;
        modalW = parent.document.body.clientWidth * 0.9;
        modalH = parent.document.body.clientHeight * 0.75;
        if (!modalTitle && shortcodeName != '') {
            modalTitle = shortcodeName.replace('pb_', '');
            modalTitle = modalTitle.slice(0, 1).toUpperCase() + modalTitle.slice(1);
            modalTitle = modalTitle.replace('_item', ' Item');
        }


        // Open add element Modal
        var modal = new $.JSNModal({
            frameId: 'jsn_view_modal',
            jParent: window.parent.jQuery.noConflict(),
            title: modalTitle + ' Settings',
            url: JSNPbParams.rootUrl + 'administrator/index.php?option=com_pagebuilder&view=shortcodesetting&tmpl=component&shortcode=' + shortcodeName,
            buttons: [{
                'text': 'Save',
                'id': 'selected',
                'class': 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                'click': function () {
                    if (!window.parent.jQuery.noConflict()('body').hasClass('jsn_processing')) {
                        $.HandleElement.enableProcessing();
                        var iframe = $(this).find('iframe');
                        // TODO save data.
                        // Update changed params

                        $('body').trigger('before_save_modal', [_this]);
                        iframe[0].contentWindow.JoomlaShine.jQuery.ShortcodeSetting.updateShortcodeParams();

                        var params = iframe.contents().find('#shortcode_content').val();
                        var el_title = '';
                        el_title = iframe.contents().find('input[data-role="title"]').val();
                        if (iframe.contents().find('textarea[data-role="title"]').length) {
                            el_title = iframe.contents().find('textarea[data-role="title"]').val();
                        }
                        var shortcode = iframe.contents().find('#shortcode_name').val();

                        $.post(
                            JSNPbParams.rootUrl + '/administrator/index.php?option=com_pagebuilder&task=shortcode.generateHolder',
                            {
                                'params': encodeURIComponent(params),
                                'shortcode': shortcode,
                                'el_title': el_title
                            },
                            function (data) {
                                if (shortcode == 'pb_row' && typeof( _this ) != 'undefined') {
                                    params = params.replace('[/pb_row]', '');
                                    _this.closest('.jsn-row-container').find('[name="shortcode_content[]"]').first().text(params);
                                }
                                $('body').trigger('jsnpb_before_changed');
                                if (isEdit) {
                                    $(addedElementContainer).replaceWith(data);
                                } else {
                                    $(addedElementContainer).append(data);
                                }

                                $.HandleElement.finalize();
                                window.parent.jQuery.noConflict()('.jsn-modal-overlay').remove();
                                window.parent.jQuery.noConflict()('.jsn-modal-indicator').remove();

                                $('body').trigger('jsnpb_changed');
                                $.HandleElement.initEditElement();
                                $('#pb_previewing').val('1');
                                $.HandleElement.disableProcessing();
                                if (isSubmodal == true) {
                                    $.ShortcodeSetting.shortcodePreview();
                                    $("body").css({overflow: 'auto'});
                                } else {
                                    $("body").css({overflow: 'auto'});
                                }
                            }
                        );
                    }
                }
            }, {
                'text': 'Cancel',
                'id': 'close',
                'class': 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                'click': function () {
                    $.HandleElement.finalize();
                    window.parent.jQuery.noConflict()('.jsn-modal-overlay').remove();
                    window.parent.jQuery.noConflict()('.jsn-modal-indicator').remove();
                    $("body").css({overflow: 'auto'});
                }
            }],
            loaded: function (obj, iframe) {

                $("body").css({overflow: 'hidden'});
                // Replace PB_INDEX_TRICK with count element items.
                var role_title = '';
                if (typeof( isEdit ) !== undefined && isEdit === false) {
                    role_title = $(iframe).contents().find('#modalOptions input[data-role="title"]').val();
                    if (role_title) {
                        role_title = role_title.replace(/PB_INDEX_TRICK/g, count + 1);
                    }
                } else {
                    role_title = $(iframe).contents().find('#modalOptions input[data-role="title"]').val();
                    if (role_title) {
                        role_title = role_title.replace(/PB_INDEX_TRICK/g, 1);
                    }
                }
                $(iframe).contents().find('#modalOptions input[data-role="title"]').attr('value', role_title);
                $(iframe).contents().find('#modalOptions input[data-role="title"]').val(role_title);

               // JSNPBParentModal = modal;
            	//JSNPBParentModal.container.closest('.ui-dialog').css('z-index', parseInt(window.parent.JSNPBParentModal.container.closest('.ui-dialog').css('z-index')) + 4);

                // Bind trigger event when load googlemap item

                if (isSubmodal == true) {
                	obj.container.closest('.ui-dialog').css('z-index', 10011);
                    $('body').trigger('pb_submodal_load', [iframe]);
                }
                $(window).resize(function () {
                    modalW = parent.document.body.clientWidth * 0.9;
                    modalH = parent.document.body.clientHeight * 0.75;
                    winW = parent.document.body.clientWidth;
                    $('.jsn-master .jsn-elementselector .jsn-items-list').css('overflow', 'auto').css('height', modalH - 220);
                    $("#pb-add-element").css('height', modalH - 200);
                    $('.ui-dialog').css('width', modalW);
                    $('.ui-dialog').css('left', winW / 2 - modalW / 2);
                });
                $(document).keyup(function (e) {
                    var keyCode = (e.keyCode ? e.keyCode : e.which)
                    if (keyCode == 27) {
                        $.HandleElement.finalize();
                        $("body").css({overflow: 'auto'});
                    }
                });
            },
            fadeIn: 200,
            scrollable: true,
            width: modalW,
            height: modalH
        });
        modal.show();
    }

    // finalize when click Save/Cancel modal
    $.HandleElement.finalize = function (remove_modal) {
        $('body').trigger('on_update_attr_label_common');
        $('body').trigger('on_update_attr_label_setting');

        // Remove Modal
        if (remove_modal || remove_modal == null)
        {
           window.parent.jQuery.noConflict()('.jsn-modal').last().remove();
        }

        $("#form-container").find('.jsn-icon-loading').remove();

        // remove overlay & loading
        $.HandleElement.hideLoading();

        $.HandleElement.removeModal();
        $.PbDoing.addElement = 0;
        $.PbDoing.editElement = 0;
    }

    /**
     * Remove Modal, Show Loading, Hide Loading
     */
    $.HandleElement.removeModal = function () {
        $('.jsn-modal').remove();
    },

    /**
     * Show loading indicator
     */
        $.HandleElement.showLoading = function () {
            var $selector = $;//window.parent.jQuery.noConflict();

            var $overlay = $selector('.jsn-modal-overlay');
            if ($overlay.size() == 0) {
                $overlay = $('<div/>', {'class': 'jsn-modal-overlay'});
            }

            var $indicator = $selector('.jsn-modal-indicator');
            if ($indicator.size() == 0) {
                $indicator = $('<div/>', {'class': 'jsn-modal-indicator'});
            }

            $selector('body')
                .append($overlay)
                .append($indicator);
            $overlay.css({'z-index': 100}).show();
            $indicator.show();
        }

    $.HandleElement.hideLoading = function () {
        var $selector = $;//window.parent.jQuery.noConflict()
        $selector('.jsn-modal-overlay').hide();
        $selector('.jsn-modal-indicator').hide();
    }

    /**
     * delete an element (a row OR a column OR an shortcode item)
     */
    $.HandleElement.deleteElement = function () {
        $("#form-container").delegate(".element-delete", "click", function () {
            var msg, is_column;
            if ($(this).hasClass('row') || $(this).attr("data-target") == "row_table") {
                msg = "Are you sure you want to remove row?";
            } else if ($(this).hasClass('column') || $(this).attr("data-target") == "column_table") {
                msg = "Are you sure you want to remove column?";
                is_column = 1;
            } else {
                msg = "Are you sure you want to remove element?";
            }

            var confirm_ = confirm(msg);
            if (confirm_) {
                var $column = $(this).parent('.jsn-iconbar').parent('.shortcode-container');
                if (is_column == 1) {
                    // Delete a Column in Table element
                    if ($(this).attr("data-target") == "column_table") {
                        var table = new $.PBTable();
                        table.deleteColRow($(this), 'column');
                        //$.HandleSetting.shortcodePreview();
                    } else {
                        var $row = $column.parent('.row-content').parent('.row-region');
                        // if is last column of row, remove parent row
                        if ($column.parent('.row-content').find('.column-region').length == 1) {
                            $.HandleElement.removeElement($row);
                        } else {
                            $.HandleElement.removeElement($column);
                        }
                    }
                }
                else {
                    // Delete a Row in Table element
                    if ($(this).attr("data-target") == "row_table") {
                        table = new $.PBTable();
                        table.deleteColRow($(this), 'row');
                        //$.HandleSetting.shortcodePreview();
                    } else {
                        $.HandleElement.removeElement($column);
                    }
                }
                $.ShortcodeSetting.shortcodePreview();
            }
        });
    };

    // Clone an Element
    $.HandleElement.cloneElement = function () {
        $('#form-container').delegate('.element-clone', 'click', function () {
            if ($.PbDoing.cloneElement)
                return;
            $.PbDoing.cloneElement = 1;

            var parent_item = $(this).parent('.jsn-iconbar').parent('.jsn-item');

            var height_ = parent_item.height();
            var clone_item = parent_item.clone(true);


            var item_class = $('#modalOptions').length ? '.jsn-item-content' : '.pb-plg-element';
            // Update title for clone element
            var html = clone_item.html();

            if (item_class == '.jsn-item-content'){
                append_title_el = parent_item.find(item_class).html();

            }
            else {
                append_title_el = parent_item.find(item_class).find('span').html();

                if (typeof( append_title_el ) == 'undefined') {
                    append_title_el = parent_item.find(item_class).html();

                }
            }


            var regexp = new RegExp(append_title_el, "g");
            //  var regexpAttr = new RegExp(prtbl_item_attr_id, "g");
            html = html.replace(regexp, append_title_el + ' ' + JSNPbParams.pbstrings.COPY);
            clone_item.html(html);

            var textarea_content = clone_item.find("[name^='shortcode_content']").text();

            textarea_content = textarea_content.replace(/(prtbl_item_attr_id=")([^\"]+)(")/, '$1' + $.HandleElement.randomString(8) + '$3');

            clone_item.find("[name^='shortcode_content']").text(textarea_content);
            //prtbl_item_attr_id
            // Add animation before insert
            $.HandleElement.appendElementAnimate(clone_item, height_, function () {
                clone_item.insertAfter(parent_item);
                if ($('#form-container').hasClass('fullmode')) {
                    // active iframe preview for cloned element
                    $(clone_item[0]).find('form.shortcode-preview-form').remove();
                    $(clone_item[0]).find('iframe').remove();
                    //$.HandleElement.turnOnShortcodePreview(clone_item[0]);
                }
            }, function () {
                $('body').trigger('jsnpb_changed');
                $.PbDoing.cloneElement = 0;
            });
            $('#pb_previewing').val('1');
            $.ShortcodeSetting.shortcodePreview();
        });
    }

    $.HandleElement.randomString = function(length) {
        var result 	= '';
        var chars	= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
        return result;
    }

    /**
     * Remove an element in Pagebuilder / In Modal
     */
    $.HandleElement.removeElement = function (element) {
        $('body').trigger('jsnpb_changed');
        element.css({
            'min-height': 0,
            'overflow': 'hidden'
        });
        element.animate({
            opacity: 0
        }, 300, 'easeOutCubic', function () {
            element.animate({
                height: 0,
                'padding-top': 0,
                'padding-bottom': 0
            }, 300, 'easeOutCubic', function () {
                element.remove();
                $('body').trigger('on_after_delete_element');
                $('body').trigger('jsnpb_changed');
                // for shortcode which has sub-shortcode
                if ($("#modalOptions").find('.has_submodal').length > 0) {
                    $.HandleElement.rescanShortcode();
                }
            });
        });
    }

    /**
     * For Parent Shortcode: Rescan sub-shortcodes content, call preview
     * function to regenerate preview
     */
    $.HandleElement.rescanShortcode = function (curr_iframe, callback) {
        try {
            $.ShortcodeSetting.shortcodePreview(null, null, curr_iframe, callback);
        } catch (err) {
            console.log(err);
        }
    }

    // Animation when add new element to container
    $.HandleElement.appendElementAnimate = function (new_el, height_, callback, finished) {
        $('body').trigger('jsnpb_changed');
        var obj_return = {
            obj_element: new_el
        };
        $('body').trigger('on_clone_element_item', [obj_return]);
        new_el = obj_return.obj_element;
        new_el.css({
            'opacity': 0
        });
        new_el.addClass('padTB0');
        if (callback)callback();
        new_el.show();
        new_el.animate({
            height: height_
        }, 500, 'easeOutCubic', function () {
            $(this).animate({
                opacity: 1
            }, 300, 'easeOutCubic', function () {
                new_el.removeClass('padTB0');
                new_el.css('height', 'auto');
                $('body').trigger('on_update_attr_label_common');
                $('body').trigger('on_update_attr_label_setting');

                if (finished)finished();
            });
        });
    }

    $.HandleElement.sliceContent = function (text) {
        text = unescape(text);
        text = text.replace(/\+/g, ' ');

        var arr = text.split(' ');
        arr = arr.slice(0, 10);
        return arr.join(' ');
    }


    /**
     * Traverse parameters, get theirs values
     */
    $.HandleElement.traverseParam = function( $selector, child_element ){
        var sc_content = '';
        var params_arr = {};

        $selector.each( function ()
        {

            if ( ! $(this).hasClass( 'pb_hidden_depend' ) )
            {

                $(this).find( '[id^="param-"]' ).each(function()
                {
                    // Bypass the Copy style group
                    if ( $(this).attr('id') == 'param-copy_style_from' ) {
                        return;
                    }

                    if(
                        $(this).parents(".tmce-active").length == 0 && ! $(this).hasClass('tmce-active')
                        && $(this).parents(".html-active").length == 0 && ! $(this).hasClass('html-active')
                        && ! $(this).parents("[id^='parent-param']").hasClass( 'pb_hidden_depend' )
                        && ( child_element || ! $(this).closest('.form-group').parent().hasClass('sub-element-settings'))
                        && $(this).attr('id').indexOf('parent-') == -1
                    )
                    {
                        var id = $(this).attr('id');
                        if($(this)){
                            sc_content =  $(this).val();//.replace(/\[/g,"&#91;").replace(/\]/g,"&#93;");
                        }else{
                            if(($(this).is(":radio") || $(this).is(":checkbox")) && !$(this).is(":checked"));
                            else{
                                if(!params_arr[id.replace('param-','')] || id.replace('param-', '') == 'title_font_face_type' || id.replace('param-', '') == 'title_font_face_value' || id.replace('param-','') == 'font_face_type' || id.replace('param-','') == 'font_face_value' || id.replace('param-', '') == 'image_type_post' || id.replace('param-', '') == 'image_type_page' || id.replace('param-', '') == 'image_type_category' ) {
                                    params_arr[id.replace('param-','')] = $(this).val();
                                } else {
                                    params_arr[id.replace('param-','')] += '__#__' + $(this).val();
                                }
                            }
                        }
                    }

                });
            }
        });

        return { sc_content : sc_content, params_arr : params_arr };
    }

    /**
     * Generate shortcode content
     */
    $.HandleElement.generateShortcodeContent = function(shortcode_name, params_arr, sc_content){
        var tmp_content = [];

        tmp_content.push('['+ shortcode_name);
        // wrap key, value of params to this format: key = "value"
        $.each(params_arr, function(key, value){
            if ( value ) {
                if ( value instanceof Array ) {
                    value = value.toString();
                }
                tmp_content.push(key + '="' + value.replace(/\"/g,"&quot;").replace(/\[/g,"").replace(/\]/g,"") + '"');

            }
        });
        // step_to_track(6,tmp_content);
        tmp_content.push(']' + sc_content + '[/' + shortcode_name + ']');
        tmp_content	= tmp_content.join( ' ' );

        return tmp_content;
    }

    $.HandleElement.customCss = function () {
        //show modal
        setTimeout(function () {
            var modalw = $(window.parent).width() * 0.9;
            var modalh = $(window.parent).height() * 0.9;
            var framId = 'custom-css-modal';
            var modal;
            var content_id = $('#top-btn-actions').find('[name="pb_content_id"]').val();

            var frame_url = JSNPbParams.rootUrl + 'administrator/index.php?option=com_pagebuilder&view=builder&tmpl=component&pb_custom_css=1&id=' + content_id;
            $('button.page-custom-css').on('click', function (e) {

                if ($(this).find('.btn').hasClass('disabled')) {
                    return;
                }

                modal = new $.JSNModal({
                    frameId: framId,
                    jParent: window.parent.jQuery.noConflict(),
                    title: 'Custom Css',
                    url: frame_url,
                    buttons: [{
                        'text': 'Save',
                        'id': 'selected',
                        'class': 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                        'click': function () {

                            var jParent = window.parent.jQuery.noConflict();
                            // get css file (link + checked status), save custom css
                            var iframe_content = jParent('#' + framId).contents();
                            var css_files = [];
                            iframe_content.find('#pb-custom-css-box').find('.jsn-items-list').find('li').each(function (i) {
                                var input = $(this).find('input');
                                var checked = input.is(':checked');
                                var url = input.val();
                                var item = {
                                    'checked': checked,
                                    'url': url
                                };
                                css_files.push(item);
                            });
                            var css_files = JSON.stringify({data: css_files});

                            //get custom css code
                            var custom_css = iframe_content.find('#custom-css').val();

                            //save data
                            $.post(
                                JSNPbParams.rootUrl + 'administrator/index.php?option=com_pagebuilder&task=builder.save_css_custom',
                                {
                                    action: 'save_css_custom',
                                    content_id: content_id,
                                    css_files: css_files,
                                    css_custom: custom_css
                                },
                                function (data) {

                                    //close loading
                                    $.HandleElement.hideLoading();
                                });
                            //close modal
                            $.HandleElement.finalize(0);
                            //show loading
                            //$.HandleElement.showLoading();
                        }
                    }, {
                        'text': 'Cancel',
                        'id': 'close',
                        'class': 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                        'click': function () {

                            $.HandleElement.hideLoading();
                            $.HandleElement.removeModal();
                            $('body').css({overflow: 'auto'});
                        }
                    }],
                    loaded: function () {

                    },
                    fadeIn: 200,
                    scrollable: true,
                    width: modalw,
                    height: modalh
                });
                modal.show();
            });

        }, 200);

    }


    $.HandleElement.init = function () {
        $.HandleElement.customCss();
    }

    $(document).ready($.HandleElement.init);
})(JoomlaShine.jQuery);
