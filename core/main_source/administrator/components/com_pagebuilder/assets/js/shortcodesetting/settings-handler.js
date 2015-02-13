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
    $.ShortcodeSetting = {};
    $.ShortcodeSetting.selectModal = null;
    $.ShortcodeSetting.initSize = 1;
    /**
     * Update shortcode params to an input
     * which will be submitted.
     */
    $.ShortcodeSetting.updateShortcodeParams = function (params, shortcode_name, curr_iframe) {
        var tmp_content = [];
        var params_arr = {};
        var shortcode_name, el_type = 'element';
        if (params == null) {
            shortcode_name = $.ShortcodeSetting.selector(curr_iframe, '#modalOptions #shortcode_name').val();
            tmp_content.push('[' + shortcode_name);
            var sc_content = '';
            $.ShortcodeSetting.selector(curr_iframe, '#modalOptions .control-group').each(function () {
                if (!$(this).hasClass('pb_hidden_depend')) {
                    $(this).find("[id^='param-']").each(function () {
                        if (
                            $(this).parents(".tmce-active").length == 0 && !$(this).hasClass('tmce-active')
                            && $(this).parents(".html-active").length == 0 && !$(this).hasClass('html-active')
                            && !$(this).parents("[id^='parent-param']").hasClass('pb_hidden_depend')
                            && $(this).attr('id').indexOf('parent-') == -1
                            && $(this).parents('.jsn_tiny_mce').length == 0 && !$(this).hasClass('jsn_tiny_mce')
                        ) {
                            var id = $(this).attr('id');
                            if ($(this).attr('data-role') == 'content') {
                                sc_content = $(this).val();
                            } else {
                                if (($(this).is(":radio") || $(this).is(":checkbox")) && !$(this).is(":checked"));
                                else {
                                    if (!params_arr[id.replace('param-', '')] || id.replace('param-', '') == 'title_font_face_type' || id.replace('param-', '') == 'title_font_face_value' || id.replace('param-', '') == 'font_face_type' || id.replace('param-', '') == 'font_face_value' || id.replace('param-', '') == 'image_type_post' || id.replace('param-', '') == 'image_type_page' || id.replace('param-', '') == 'image_type_category') {
                                        params_arr[id.replace('param-', '')] = $(this).val();
                                    } else {
                                        params_arr[id.replace('param-', '')] += '__#__' + $(this).val();
                                    }
                                }
                            }

                            // data-share
                            if ($(this).attr('data-share')) {
                                var share_element = $('#' + $(this).attr('data-share'));
                                var share_data = share_element.text();
                                if (share_data == "" || share_data == null)
                                    share_element.text($(this).val());
                                else {
                                    share_element.text(share_data + ',' + $(this).val());
                                    var arr = share_element.text().split(',');
                                    $.unique(arr);
                                    share_element.text(arr.join(','));
                                }

                            }

                            // data-merge
                            if ($(this).parent().hasClass('merge-data')) {
                                var pb_merge_data = window.parent.jQuery.noConflict()('#jsn_view_modal').contents().find('#pb_merge_data');
                                pb_merge_data.text(pb_merge_data.text() + $(this).val());
                            }

                            // table
                            if ($(this).attr("data-role") == "extract") {
                                var extract_holder = window.parent.jQuery.noConflict()('#jsn_view_modal').contents().find('#pb_extract_data');
                                extract_holder.text(extract_holder.text() + $(this).attr("id") + ':' + $(this).val() + '#');
                            }
                        }

                    });
                }
            });

            // update tinyMCE content
            var tinyContent = '';
            $('.jsn_tiny_mce').each(function () {
                if ($(this).hasClass('role_content')) {
                    tinyContent = $(this).wysiwyg('getContent');
                }
            });
            sc_content += tinyContent;

            // for shortcode which has sub-shortcode
            if ($.ShortcodeSetting.selector(curr_iframe, "#modalOptions").find('.has_submodal').length > 0 || $.ShortcodeSetting.selector(curr_iframe, '#modalOptions').find('.submodal_frame_2').length > 0) {
                var sub_sc_content = [];
                $.ShortcodeSetting.selector(curr_iframe, "#modalOptions [name^='shortcode_content']").each(function () {
                    if (!$(this).hasClass('exclude_gen_shortcode')) {
                        sub_sc_content.push($(this).text());
                    }
                })
                sc_content += sub_sc_content.join('');
            }

            // wrap key, value of params to this format: key = "value"
            $.each(params_arr, function (key, value) {
                if (value) {
                    if (value instanceof Array) {
                        value = value.toString();
                    }
                    tmp_content.push(key + '="' + value.replace(/\"/g, "&quot;") + '"');
                }
            });

            tmp_content.push(']' + sc_content + '[/' + shortcode_name + ']');
            tmp_content = tmp_content.join(' ');
        } else {
            shortcode_name = shortcode;
            tmp_content = params;
        }

        $('#shortcode_content').html(tmp_content);
    }

    /**
     * Select element(s) in setting modal
     *
     */
    $.ShortcodeSetting.selector = function (curr_iframe, element) {
        var $selector = (curr_iframe != null && curr_iframe.contents() != null) ? curr_iframe.contents().find(element) : $(element);
        return $selector;
    }

    // Show tab in Modal Options
    $.ShortcodeSetting.tab = function () {
        $('#pb_option_tab a[href="#content"]').on('click', function () {
            if ($('#pb_previewing').val() == '1')
                return;
            $('#pb_previewing').val('1');
            $.ShortcodeSetting.shortcodePreview();
        });
        if (!$('.jsn-tabs').find("#Notab").length)
            $('.jsn-tabs').tabs();
        return true;
    }

    $.ShortcodeSetting.select2 = function () {
        $(".select2").each(function () {
            var share_element = window.parent.jQuery.noConflict()('#jsn_view_modal').contents().find('#' + $(this).attr('data-share'));
            var share_data = [];
            if (share_element && share_element.text() != "") {
                share_data = share_element.text().split(',');
                share_data = $.unique(share_data);
            }
            $(this).css('width', '300px');
            $(this).select2({
                tags: share_data,
                maximumInputLength: 10
            });
        })

        $('.select2-select').each(function () {
            var id = $(this).attr('id');
            if ($('#' + id + '_select_multi').val()) {
                var arr_select_multi = $('#' + id + '_select_multi').val().split('__#__');
                $(this).val(arr_select_multi).select2();
            } else {
                $(this).select2();
            }
        });

        $.ShortcodeSetting.select2_color();
    }

    $.ShortcodeSetting.select2_color = function () {
        function format(state) {
            if (!state.id) return state.text; // optgroup
            var type = state.id.toLowerCase();
            type = type.split('-');
            type = type[type.length - 1];
            return "<img class='color_select2_item' src='" + JSNPbParams.rootUrl + "administrator/components/com_pagebuilder/assets/images/icons-16/btn-color/" + type + ".png'/>" + state.text;
        }

        $('.color_select2').not('.hidden').each(function () {
            $(this).find('select').each(function () {
                $(this).select2({
                    formatResult: format,
                    formatSelection: format,
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            });
        });
    }

    $.ShortcodeSetting.changeDependency = function (dp_selector) {
        if (!dp_selector)
            return false;

        $('#modalOptions').delegate(dp_selector, 'change', function () {
            var this_id = $(this).attr('id');
            var this_val = $(this).val();
            $.ShortcodeSetting.toggleDependency(this_id, this_val);
        });
    }

    // Show or hide dependency params
    $.ShortcodeSetting.toggleDependency = function (this_id, this_val) {
        if (!this_id || !this_val) {
            return;
        }
        $('#modalOptions .pb_depend_other[data-depend-element="' + this_id + '"]').each(function () {
            var operator = $(this).attr('data-depend-operator');
            var compare_value = $(this).attr('data-depend-value');
            switch (operator) {
                case '=':
                {
                    var check_ = 0;
                    if (compare_value.indexOf('__#__') > 0) {
                        var values_ = compare_value.split('__#__');
                        check_ = ($.inArray(this_val, values_) >= 0);
                    }
                    else
                        check_ = (this_val == compare_value);
                    if (check_)
                        $(this).removeClass('pb_hidden_depend');
                    else
                        $(this).addClass('pb_hidden_depend');
                }
                    break;
                case '>':
                {
                    if (this_val > compare_value)
                        $(this).removeClass('pb_hidden_depend');
                    else
                        $(this).addClass('pb_hidden_depend');
                }
                    break;
                case '<':
                {
                    if (this_val < compare_value)
                        $(this).removeClass('pb_hidden_depend');
                    else
                        $(this).addClass('pb_hidden_depend');
                }
                    break;
                case '!=':
                {
                    if (this_val != compare_value)
                        $(this).removeClass('pb_hidden_depend');
                    else
                        $(this).addClass('pb_hidden_depend');
                }
            }
            $.ShortcodeSetting.secondDependency($(this).attr('id'), $(this).hasClass('pb_hidden_depend'), $(this).find('select').hasClass('no_plus_depend'));

            $('body').trigger('pb_after_change_depend');
        });
    }

    $.ShortcodeSetting.secondDependency = function (this_id, hidden, allow) {
        if (!this_id) {
            return;
        }
        this_id = this_id.replace('parent-', '');
        $('#modalOptions .pb_depend_other[data-depend-element="' + this_id + '"]').each(function () {
            if (hidden)
                $(this).addClass('pb_hidden_depend2');
            else
                $(this).removeClass('pb_hidden_depend2');
        });
        if (!allow) {
            $('#modalOptions .pb_depend_other[data-depend-element="' + this_id + '"]').each(function () {
                $(this).removeClass('pb_hidden_depend2');
            });
        }
        // hide label if all options in .controls div have 'pb_hidden_depend' class
        $('#modalOptions .controls').each(function () {
            var hidden_div = 0;
            $(this).children().each(function () {
                if ($(this).hasClass('pb_hidden_depend'))
                    hidden_div++;
            });
            if (hidden_div > 0 && hidden_div == $(this).children().length) {
                $(this).parent('.control-group').addClass('margin0');
                $(this).prev('.control-label').hide();
            }
            else {
                $(this).parent('.control-group').removeClass('margin0');
                $(this).prev('.control-label').show();
            }
        });
    }

    $.ShortcodeSetting.updateState = function (state) {
        if (state != null) {
            $.ShortcodeSetting.doing = state;
        }
        else {
            if ($.ShortcodeSetting.doing == null || $.ShortcodeSetting.doing)
                $.ShortcodeSetting.doing = 0;
            else
                $.ShortcodeSetting.doing = 1;
        }
    }

    $.ShortcodeSetting.renderModal = function () {
        if ($("#modalOptions").length == 0) return false;
        var params = '';

        // toggle dependency params
        var itHasDepend = $('#modalOptions .pb_has_depend');
        itHasDepend.each(function () {
            if (($(this).is(":radio") || $(this).is(":checkbox")) && !$(this).is(":checked")) return;
            var this_id = $(this).attr('id');
            var this_val = $(this).val();
            $.ShortcodeSetting.toggleDependency(this_id, this_val);
        });
        //$.ShortcodeSetting.shortcodePreview(params, shortcode, null, null, false);
    }

    $.ShortcodeSetting.selectImage = function () {
        $('#modalOptions .select-media-remove').on('click', function () {
            var _input = $(this).closest('div').find('input[type="text"]');
            _input.attr('value', '');
            _input.trigger('change');
        });

        $('.select-media').on('click', function () {
            var value = $(this).prev('.select-media-text').val();
            var id = $(this).prev('.select-media-text').attr('id');
            $.ShortcodeSetting.selectModal = new $.JSNModal({
                frameId: 'jsn_select_image_modal',
                jParent: window.parent.jQuery.noConflict(),
                title: 'Choose File',
                url: JSNPbParams.rootUrl + "plugins/system/jsnframework/libraries/joomlashine/choosers/media/index.php?component=com_pagebuilder&root=images&current=" + value + "&element=" + id + "&handler=setSelectImage",
                buttons: [{
                    'text': 'Cancel',
                    'id': 'close',
                    'class': 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                    'click': function () {
                        $.ShortcodeSetting.selectModal.close();
                        $.HandleElement.hideLoading();
                        $.HandleElement.finalize();
                    }
                }],
                width: parent.document.body.clientWidth * 0.9,
                height: parent.document.body.clientHeight * 0.75,
                loaded: function (obj, iframe) {
                    $.HandleElement.hideLoading();
                    obj.container.closest('.ui-dialog').css('z-index', 10014);
                }
            });
            $.ShortcodeSetting.selectModal.show();
        });
    },

        window.parent.setSelectImage = function (value, id) {
            $(id).val(value.replace(/^\//, ""));
            $.ShortcodeSetting.selectModal.close();
            $.HandleElement.hideLoading();
            $.HandleElement.finalize();
            $.ShortcodeSetting.shortcodePreview();
        }

    //Setup for select module elements
    $.ShortcodeSetting.selectModule = function () {
        $('#parent-param-module_name .select-module-remove').on('click', function () {
            var _input = $(this).closest('div').find('input[type="text"]');
            _input.attr('value', '');
            _input.trigger('change');
        });
        $('.select-module').on('click', function () {
            $.HandleElement.showLoading();
            var value = $(this).prev('.select-module-text').val();
            var id = $(this).prev('select-module-text').attr('id');
            var modal_width, modal_height;
            modal_width = parent.document.body.clientWidth * 0.9;
            modal_height = parent.document.body.clientHeight * 0.75;
            $.ShortcodeSetting.selectModal = new $.JSNModal({
                frameId: 'jsn_select_module_modal',
                jParent: window.parent.jQuery.noConflict(),
                title: 'Select Module',
                url: JSNPbParams.rootUrl + "administrator/index.php?option=com_pagebuilder&view=selectmodule&tmpl=component&current=" + value + "&element=" + id + "&handler=setSelectModule",
                buttons: [{
                    'text': 'Cancel',
                    'id': 'close',
                    'class': 'ui-button ui-widget ui-state-default ui-correr-all ui-button-text-only',
                    'click': function () {
                        $.ShortcodeSetting.selectModal.close();
                        $.HandleElement.finalize();
                    }
                }],
                width: modal_width,
                height: modal_height,
                fadeIn: 200,
                scrollable: true,
                loaded: function (iframe) {
                    var $frame = this.jParent("#" + this.frameId);
                    var $titleBar = $frame.parent().parent().find('.ui-dialog-titlebar').append('<div class="filter-search btn-group pull-right"><div class="jsn-quick-search"><input id="filter_search" name="filter_search" class="input search-query" type="text" placeholder="Search..."><a id="reset-search-btn" class="jsn-reset-search" title="Clear Search" href="javascript:void(0);"><i class="icon-remove"></i></a></div></div></div>');
                    // focus searchbox on firefox
                    $titleBar.find('#filter_search').click(function () {
                        $(this).focus();
                    })
                    this.jParent.fn.delayKeyup = function (callback, ms) {
                        var timer = 0;
                        var md = $(this);
                        $(this).keyup(function () {
                            clearTimeout(timer);
                            timer = setTimeout(function () {
                                callback(md);
                            }, ms);
                        });
                        return $(this);
                    };

                    $titleBar.find('#filter_search').keydown(function (e) {
                        if (e.which == 13) {
                            return false;
                        }
                    });

                    $titleBar.find('#filter_search').delayKeyup(function (md) {
                        if ($(md).val() != '') {
                            $titleBar.find("#reset-search-btn").show();
                        } else {
                            $titleBar.find("#reset-search-btn").hide();
                        }
                        self.filterModule($(md).val(), 'value');
                    }, 500);

                    $titleBar.find("#reset-search-btn").click(function () {
                        self.filterModule("all");
                        $(this).hide();
                        $titleBar.find("#filter_search").val("");
                    });
                    filterModule = function (value) {
                        var resultsFilter = $frame.contents().find('#jsn-module-container');
                        if (value != "all") {
                            $(resultsFilter).find(".jsn-item-type").hide();
                            $(resultsFilter).find(".jsn-item-type").each(function () {
                                var findDiv = $(this).find("div");
                                var textField = textField ? findDiv.attr("data-module-title").toLowerCase() : findDiv.attr("title").toLowerCase();
                                if (textField.search(value.toLowerCase()) === -1) {
                                    $(this).hide();
                                } else {
                                    $(this).fadeIn(500);
                                }
                            });
                        }
                        else $(resultsFilter).find(".jsn-item-type").show();
                    }
                    //$frame.contents().find('.loading-bar').hide();
                    $.HandleElement.hideLoading();
                }
            });
            $.ShortcodeSetting.selectModal.show();

        });
    },
        window.parent.setSelectModule = function (value, id) {
            $(id).val(value);
            $.ShortcodeSetting.selectModal.close();
            $.HandleElement.finalize();
            $.HandleElement.hideLoading();
            $.ShortcodeSetting.shortcodePreview();
        };

    $.ShortcodeSetting.filterModule = function (value) {
        var resultsFilter = $('#jsn-module-container');
        if (value != "all") {
            $(resultsFilter).find(".jsn-item-type").hide();
            $(resultsFilter).find(".jsn-item-type").each(function () {
                var textField = $(this).find("div").attr("data-module-title").toLowerCase();
                if (textField.search(value.toLowerCase()) === -1) {
                    $(this).hide();
                } else {
                    $(this).fadeIn(500);
                }
            });
        }
        else $(resultsFilter).find(".jsn-item-type").show();

    }
    $.ShortcodeSetting.search = function () {
        var self = this;
        $.fn.delayKeyup = function (callback, ms) {
            var timer = 0;
            var el = $(this);
            $(this).keyup(function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback(el);
                }, ms);
            });
            return $(this);
        };
        $('#jsn-quicksearch-field').keydown(function (e) {
            if (e.which == 13)
                return false;
        });
        $('jsn-quicksearch-field').delayKeyup(function (el) {
            if ($(el).val() != '') {
                $('#reset-search-btn').show();
            } else {
                $('#reset-search-btn').hide();
            }
            self.filterModule($(el).val(), 'value');
        }, 500);
        $('.jsn-filter-button').change(function () {
            self.filterModule($(this).val(), 'type');
        });
        $('#reset-search-btn').click(function () {
            self.filterModule("all");
            $(this).hide();
            $('#jsn-quicksearch-field').val("");
        });
    },

        // Setup for tiny-mce
        $.ShortcodeSetting.setTinyMCE = function (selector) {
            $(selector).each(function () {
                var current_id = $(this).attr('id');
                if (current_id) {
                    $('#' + current_id).wysiwyg({
                        controls: {
                            bold: {visible: true},
                            italic: {visible: true},
                            underline: {visible: true},
                            strikeThrough: {visible: true},

                            justifyLeft: {visible: true},
                            justifyCenter: {visible: true},
                            justifyRight: {visible: true},
                            justifyFull: {visible: true},

                            indent: {visible: true},
                            outdent: {visible: true},

                            subscript: {visible: true},
                            superscript: {visible: true},

                            undo: {visible: true},
                            redo: {visible: true},

                            insertOrderedList: {visible: true},
                            insertUnorderedList: {visible: true},
                            insertHorizontalRule: {visible: true},

                            h1: {
                                visible: true,
                                className: 'h1',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h1>' : 'h1',
                                tags: ['h1'],
                                tooltip: 'Header 1'

                            },
                            h2: {
                                visible: true,
                                className: 'h2',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h2>' : 'h2',
                                tags: ['h2'],
                                tooltip: 'Header 2'
                            },
                            h3: {
                                visible: true,
                                className: 'h3',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h3>' : 'h3',
                                tags: ['h3'],
                                tooltip: 'Header 3'
                            },
                            h4: {
                                visible: true,
                                className: 'h4',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h4>' : 'h4',
                                tags: ['h4'],
                                tooltip: 'Header 4'

                            },
                            h5: {
                                visible: true,
                                className: 'h5',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h5>' : 'h5',
                                tags: ['h5'],
                                tooltip: 'Header 5'
                            },
                            h6: {
                                visible: true,
                                className: 'h6',
                                command: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? 'formatBlock' : 'heading',
                                arguments: ($.browser.msie || $.browser.safari || $.browser.chrome || $.browser.webkit || $.browser.mozilla || $.browser.navigation || $.browser.opera) ? '<h6>' : 'h6',
                                tags: ['h6'],
                                tooltip: 'Header 6'
                            },

                            cut: {visible: true},
                            copy: {visible: true},
                            paste: {visible: true},
                            html: {visible: true},
                            increaseFontSize: {visible: true},
                            decreaseFontSize: {visible: true},
                            initialContent: ''
                        }
                    });
                }
            });
        }

    $.ShortcodeSetting.shortcodePreview = function (params, shortcode, curr_iframe, callback, child_element, selector_group) {
        if (($.ShortcodeSetting.selector(curr_iframe, "#modalOptions").length == 0 || $.ShortcodeSetting.selector(curr_iframe, "#modalOptions").hasClass('submodal_frame')) && curr_iframe == null)
            return true;

        var tmp_content = [];
        var params_arr = {};
        var shortcode_name, shortcode_type;
        if (params == null) {
            shortcode_name = $.ShortcodeSetting.selector(curr_iframe, '#modalOptions #shortcode_name').val();
            shortcode_type = $.ShortcodeSetting.selector(curr_iframe, '#form-container #shortcode_type').val();
            tmp_content.push('[' + shortcode_name);
            var sc_content = '';
            $.ShortcodeSetting.selector(curr_iframe, '#modalOptions .control-group').each(function () {
                if (!$(this).hasClass('pb_hidden_depend')) {
                    $(this).find("[id^='param-']").each(function () {

                        var id = $(this).attr('id');
                        if ($(this).attr('data-role') == 'content') {
                            sc_content = $(this).val();
                        } else {
                            if (($(this).is(":radio") || $(this).is(":checkbox")) && !$(this).is(":checked"));
                            else {
                                if (!params_arr[id.replace('param-', '')] || id.replace('param-', '') == 'title_font_face_type' || id.replace('param-', '') == 'title_font_face_value' || id.replace('param-', '') == 'font_face_type' || id.replace('param-', '') == 'font_face_value' || id.replace('param-', '') == 'image_type_post' || id.replace('param-', '') == 'image_type_page' || id.replace('param-', '') == 'image_type_category') {
                                    params_arr[id.replace('param-', '')] = $(this).val();
                                } else {
                                    params_arr[id.replace('param-', '')] += '__#__' + $(this).val();
                                }
                            }


                            // data-share
                            if ($(this).attr('data-share')) {
                                var share_element = $('#' + $(this).attr('data-share'));
                                var share_data = share_element.text();
                                if (share_data == "" || share_data == null)
                                    share_element.text($(this).val());
                                else {
                                    share_element.text(share_data + ',' + $(this).val());
                                    var arr = share_element.text().split(',');
                                    $.unique(arr);
                                    share_element.text(arr.join(','));
                                }

                            }

                            // data-merge
                            if ($(this).parent().hasClass('merge-data')) {
                                var pb_merge_data = window.parent.jQuery.noConflict()('#jsn_view_modal').contents().find('#pb_merge_data');
                                pb_merge_data.text(pb_merge_data.text() + $(this).val());
                            }

                            // table
                            if ($(this).attr("data-role") == "extract") {
                                var extract_holder = window.parent.jQuery.noConflict()('#jsn_view_modal').contents().find('#pb_extract_data');
                                extract_holder.text(extract_holder.text() + $(this).attr("id") + ':' + $(this).val() + '#');
                            }
                        }

                    });
                }
            });


            // for shortcode which has sub-shortcode
            if ($.ShortcodeSetting.selector(curr_iframe, "#modalOptions").find('.has_submodal').length > 0 || $.ShortcodeSetting.selector(curr_iframe, '#modalOptions').find('.submodal_frame_2').length > 0) {
                var sub_sc_content = [];
                $.ShortcodeSetting.selector(curr_iframe, "#modalOptions [name^='shortcode_content']").each(function () {
                    var sc_content = $(this).text();
                    var obj = {sc_content: sc_content};
                    $('#modalOption').trigger('pb_get_sub_sc', [obj]);
                    if (obj.sc_content != '') {
                        sub_sc_content.push(obj.sc_content);
                    }
                });
                sc_content += sub_sc_content.join('');
            }

            // wrap key, value of params to this format: key = "value"
            $.each(params_arr, function (key, value) {
                if (value) {
                    if (value instanceof Array) {
                        value = value.toString();
                    }
                    tmp_content.push(key + '="' + value.replace(/\"/g, "&quot;") + '"');
                }
            });

            tmp_content.push(']' + sc_content + '[/' + shortcode_name + ']');
            tmp_content = tmp_content.join(' ');

        }
        else {
            shortcode_name = shortcode;
            tmp_content = params;
        }

        // update shortcode content
        $.ShortcodeSetting.selector(curr_iframe, '#shortcode_content').text(tmp_content);


        if (callback)
            callback();


        var url = JSNPbParams.rootUrl;
        url += 'administrator/index.php?option=com_pagebuilder&task=shortcode.preview&tmpl=component';
        url += '&shortcode_name=' + shortcode_name;


        if ($('#shortcode_preview_iframe').length > 0) {
            // asign value to a variable (for show/hide preview)
            $.ShortcodeSetting.previewData = {
                curr_iframe: curr_iframe,
                url: url,
                tmp_content: tmp_content
            };
            // load preview iframe
            $.ShortcodeSetting.loadIframe(curr_iframe, url, tmp_content);
        }
        return false;
    }

    // load preview iframe
    $.ShortcodeSetting.loadIframe = function (curr_iframe, url, tmp_content) {
        $('#pb_preview_data').remove();
        var imageValue = $('#param-image_file').val();
        if (typeof imageValue !== 'undefined' && imageValue !== '') {
            var file = imageValue.split('.');
            var arrEx = ["jpg", 'JPG', 'png', 'PNG', 'gif', 'GIF'];
            var lengthFile = file.length;
            if (arrEx.indexOf(file[lengthFile - 1]) == -1) {
                $('<span class="pd_errFile" style="color:red"></br><i>Error:File type is not supported.</i></span>').insertAfter($('#param-image_file').parent());
                $('#param-image_file').val('');
                $('#shortcode_preview_iframe').contents().find('.pb-element-container').each(function () {
                    $(this).find('img').remove();
                });
                return false;
            } else {
                $('.pd_errFile').remove();
            }
        }
        var tmp_form = $('<form action="' + url + '" id="pb_preview_data" name="pb_preview_data" method="post" target="shortcode_preview_iframe"><input type="hidden" id="pb_preview_params" name="params" value="' + encodeURIComponent(tmp_content) + '"></form>');
        tmp_form.appendTo($('body'));
        $.ShortcodeSetting.selector(curr_iframe, '#iframeLoading').fadeIn('fast');
        $('#pb_preview_data').submit();
        $('#framePreview #shortcode_preview_iframe').bind('load', function () {
            $.ShortcodeSetting.selector(curr_iframe, '#iframeLoading').fadeOut('fast');
            $('#pb_previewing').val('0');
        });
        setTimeout(function () {
            $($("#shortcode_preview_iframe").get(0).contentDocument.body).delegate("*", "click", function (e) {
                e.preventDefault();
            })
        }, 500);
        tmp_form.remove();
    }

    // hide/show preview
    $.ShortcodeSetting.togglePreview = function () {
        $('#previewToggle *').click(function () {
            if ($(this).attr('id') == 'hide_preview') {
                $(this).addClass('hidden');
                $('#show_preview').removeClass('hidden');
                // remove iframe
                $('#preview_container iframe').remove();
            }
            else {
                $(this).addClass('hidden');
                $('#hide_preview').removeClass('hidden');
                $('#preview_container').append("<iframe scrolling='no' id='shortcode_preview_iframe' name='shortcode_preview_iframe' class='shortcode_preview_iframe' ></iframe>");
                if ($.ShortcodeSetting.previewData != null) {
                    var data = $.ShortcodeSetting.previewData;
                    $.ShortcodeSetting.loadIframe(data.curr_iframe, data.url, data.tmp_content);
                }
            }
        });
    }

    $.ShortcodeSetting.actionHandle = function () {
        $('.pb_action_btn .dropdown-menu a').on('click', function (e) {
            e.preventDefault();

            $.ShortcodeSetting.updateShortcodeParams();

            var action_type = $(this).attr('data-action-type');
            var action = $(this).attr('data-action');
            if (action_type && action) {
                if (action_type == 'convert') {
                    var arr_types = action.split('_to_');
                    var from = ( arr_types[0] ) ? arr_types[0] : '';
                    var to = ( arr_types[1] ) ? arr_types[1] : '';

                    if (from && to) {
                        var shortcode_content = $('#shortcode_content').html();
                        // Convert element
                        var regexp = new RegExp("pb_" + from, "g");
                        shortcode_content = shortcode_content.replace(regexp, "pb_" + to);
                        // Convert items
                        var regexp = new RegExp("pb_" + from + "_item", "g");
                        shortcode_content = shortcode_content.replace(regexp, "pb_" + to + "_item");
                        // Convert shortcode name in PageBuilder
                        var regexp = new RegExp($.ShortcodeSetting.capitalize(from), "g");
                        shortcode_content = shortcode_content.replace(regexp, $.ShortcodeSetting.capitalize(to));
                        // Check is add state
                        var shortcodeStr = $(this).closest('#form-container').find('#shortcode_content').text();
                        var modalTitle = $(this).text();

                        var jParent = window.parent.JoomlaShine.jQuery;
                        if (typeof(jParent) == undefined) {
                            jParent = window.parent.jQuery.noConflict();
                        }
                        // trigger save element
                        jParent('.ui-dialog #close').trigger('click');
                        if (shortcode_content) {
                            jParent('body').trigger('on_after_convert', ['pb_' + to, shortcode_content, modalTitle]);
                        }
                    }
                }
            }
        });
    }

    $.ShortcodeSetting.capitalize = function (text) {
        return text.charAt(0).toUpperCase()
            + text.slice(1).toLowerCase();
    },

        $.ShortcodeSetting.gradientPicker = function () {
            var gradientPicker = function () {
                $("input.jsn-grad-ex").each(function (i, e) {
                    $(e).next('.classy-gradient-box').first().ClassyGradient({
                        gradient: $(e).val(),
                        width: 218,
                        orientation: $('#param-gradient_direction').val(),
                        onChange: function (stringGradient, cssGradient, arrayGradient) {
                            $(e).val() == stringGradient || $(e).val(stringGradient);
                            $('#param-gradient_color_css').val(cssGradient);
                        }
                    });
                });
            }

            $('#param-background').change(function () {
                var val = $('#param-background').val();
                if (val == 'gradient') {
                    $(document).ready(function () {
                        setTimeout(function () {
                            gradientPicker();
                        }, 300);
                    });
                }
            });

            $('#param-background').trigger('change');

            // control orientation
            $('#param-gradient_direction').on('change', function () {
                var orientation = $(this).val();
                $('.classy-gradient-box').data('ClassyGradient').setOrientation(orientation);
                // update background gradient
                if (orientation == 'horizontal') {
                    $('#param-gradient_color_css').val($('#param-gradient_color_css').val().replace('left top, left bottom', 'left top, right top').replace(/\(top/g, '(left'));
                } else {
                    $('#param-gradient_color_css').val($('#param-gradient_color_css').val().replace('left top, right top', 'left top, left bottom').replace(/\(left/g, '(top'));
                }
            });
        }

    // check radio button when click button in btn-group
    $.ShortcodeSetting.buttonGroup = function () {
        var data_value;
        $('.pb-btn-group .btn').click(function (i) {
            data_value = $(this).attr('data-value');
            $(this).parent().next('.pb-btn-radio').find('input:radio[value="' + data_value + '"]').prop('checked', true);
            //$.HandleSetting.shortcodePreview();
        });
    }

    // Validator input field
    $.ShortcodeSetting.inputValidator = function () {
        var input_action = 'change paste';

        // positive value
        $('.positive-val').bind(input_action, function (event) {
            var this_val = $(this).val();
            if (parseInt(this_val) <= 0) {
                $(this).val(1);
            }
        });
    }


    $.ShortcodeSetting.resetSize = function () {
        modalW = parent.document.body.clientWidth * 0.9;
        modalH = parent.document.body.clientHeight * 0.75;
        winW = parent.document.body.clientWidth;
        var columnW = modalW / 2;
        var columnWpx = (columnW - 40 ) + 'px';
        var columnHpx;
        var column2W;

        if ($.ShortcodeSetting.initSize <= 3) {
            $.ShortcodeSetting.initSize++;
            columnHpx = (modalH - 210) + 'px';
        } else {
            columnHpx = (modalH - 300) + 'px';
        }
        $('#jsn_column1').css('height', columnHpx);
        $('#jsn_column2').css('height', columnHpx);
        $('#jsn_column1 #modalOptions #content').css('height', columnHpx).css('overflow-y', 'auto');
        $('#jsn_column1 #modalOptions #styling').css('height', columnHpx).css('overflow-y', 'auto');
        $('#jsn_column2 .preview_border').css('height', columnHpx);
        $('#jsn_column2 #framePreview #shortcode_preview_iframe').css('height', columnHpx);


        if (columnW >= 500) {
            $('#jsn_column1').css('width', '50%');
            $('#jsn_column2').css('width', '49%').css('margin-left', '1%');
        } else {
            column2W = modalW - 500 - 70;
            column2Wpx = column2W + 'px';
            if (column2W > 200) {
                $('#jsn_column1').css('width', '500px');
                $('#jsn_column2').show();
                $('#jsn_column2').css('width', column2Wpx);
            } else {
                $('#jsn_column1').css('width', '100%');
                $('#jsn_column2').hide();
            }
        }
    }

    $(document).ready(function () {

        $.ShortcodeSetting.actionHandle();

        $.ShortcodeSetting.updateState();

        // Trigger action of element which has dependency elements
        $.ShortcodeSetting.changeDependency('.pb_has_depend');

        // Send ajax for loading shortcode html at first time
        $.ShortcodeSetting.renderModal();

        $.ShortcodeSetting.tab();

        $.ShortcodeSetting.setTinyMCE('.jsn_tiny_mce');

        $.ShortcodeSetting.updateShortcodeParams();

        $.ShortcodeSetting.inputValidator();

        $('#modalOptions').delegate('[id^="param"]', 'change', function () {
            if ($(this).attr('data-role') == 'no_preview') {
                return false;
            }
            $.ShortcodeSetting.updateShortcodeParams();
        });
        // Open subshortcode modal setting
        $("#form-container").delegate(".jsn-add-more", "click", function (e) {
            e.preventDefault();
            var shortcodeName = $(this).closest('.has_submodal').attr('data-value');
            // Set the container for to-be-added element in to global variable.
            addedElementContainer = $(this).closest('.item-container').find('#group_elements');
            var shortcode = $(this).attr('data-shortcode-item');
            var modalTitle = $(this).attr('data-modal-title');
            $.HandleElement._showSettingModal(shortcode, true, false, modalTitle, $(this));
        });

        // Open edit setting modal
        $("#form-container").delegate(".element-edit", "click", function (e) {
            e.preventDefault();
            if ($.PbDoing.editElement)
                return;
            $.PbDoing.editElement = 1;

            var shortcodeItem = $(this).closest('.jsn-item').find('[name="shortcode_content[]"]');
            var shortcodeName = shortcodeItem.attr('shortcode-name');
            var params = shortcodeItem.val();
            addedElementContainer = $(this).closest('.jsn-item');
            if (typeof( shortcodeName ) != 'undefined') {
                var modalTitle = $(this).closest('.jsn-item').attr('data-modal-title');
                $.HandleElement.editElement(shortcodeName, params, modalTitle, $(this));

            }
        });

        $.ShortcodeSetting.select2();

        $.ShortcodeSetting.buttonGroup();

        $.HandleElement.cloneElement();

        $.HandleElement.deleteElement();

        // Update preview when change param in Modal Box
        $('#modalOptions').delegate('[id^="param"]', 'change', function () {
            if ($(this).attr('data-role') == 'no_preview') {
                return false;
            }
            $.ShortcodeSetting.shortcodePreview();
        });
        // Disable preview if using wysiwyg editor
        if ($('.wysiwyg').length > 0) {

            $('.wysiwyg').on('change', function () {
                return false;
            });

            $(document).on('click', function () {
                $.ShortcodeSetting.shortcodePreview();
            });
        }

        if (typeof $('#param-el_table').val() !== 'undefined') {
            setTimeout(function () {
                $.ShortcodeSetting.shortcodePreview();
            }, 500);
        }
        $.ShortcodeSetting.gradientPicker();
        // Load at first time
        $('#pb_previewing').val('1');
        $.ShortcodeSetting.shortcodePreview();
        $(window).resize(function () {
            $.ShortcodeSetting.resetSize();
        });
    });
})(JoomlaShine.jQuery);
