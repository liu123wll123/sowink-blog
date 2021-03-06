<?php
/*
    "Contact Form to Database Extension" Copyright (C) 2011 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This file is part of Contact Form to Database Extension.

    Contact Form to Database Extension is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Contact Form to Database Extension is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see <http://www.gnu.org/licenses/>.
*/

require_once('CF7DBPlugin.php');
require_once('CFDBView.php');

class CFDBViewShortCodeBuilder extends CFDBView {

    /**
     * @param  $plugin CF7DBPlugin
     * @return void
     */
    function display(&$plugin) {
        if ($plugin == null) {
            $plugin = new CF7DBPlugin;
        }
        $this->pageHeader($plugin);

        // Identify which forms have data in the database
        global $wpdb;
        $tableName = $plugin->getSubmitsTableName();
        $rows = $wpdb->get_results("select distinct `form_name` from `$tableName` order by `form_name`");
        //        if ($rows == null || count($rows) == 0) {
        //            _e('No form submissions in the database', 'contact-form-7-to-database-extension');
        //            return;
        //        }
        $currSelection = ''; // todo
        ?>
    <script type="text/javascript" language="JavaScript">

        var shortCodeDocUrls = {
            '' : 'http://cfdbplugin.com/?page_id=89',
            '[cfdb-html]' : 'http://cfdbplugin.com/?page_id=284',
            '[cfdb-table]' : 'http://cfdbplugin.com/?page_id=93',
            '[cfdb-datatable]' : 'http://cfdbplugin.com/?page_id=91',
            '[cfdb-value]' : 'http://cfdbplugin.com/?page_id=98',
            '[cfdb-count]' : 'http://cfdbplugin.com/?page_id=278',
            '[cfdb-json]' : 'http://cfdbplugin.com/?page_id=96',
            '[cfdb-export-link]' : 'http://cfdbplugin.com/?page_id=419'
        };

        function showHideOptionDivs() {
            var shortcode = jQuery('#shortcode_ctrl').val();
            jQuery('#doc_url_tag').attr('href', shortCodeDocUrls[shortcode]);
            jQuery('#doc_url_tag').html(shortcode + " <?php _e('Documentation', 'contact-form-7-to-database-extension'); ?>");
            switch (shortcode) {
                case "[cfdb-html]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').show();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-table]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').show();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-datatable]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').show();
                    jQuery('#dt_options_div').show();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-value]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').show();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-count]":
                    jQuery('#show_hide_div').hide();
                    jQuery('#limitorder_div').hide();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-json]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').show();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
                case "[cfdb-export-link]":
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').show();
                    break;
                default:
                    jQuery('#show_hide_div').show();
                    jQuery('#limitorder_div').show();
                    jQuery('#html_format_div').hide();
                    jQuery('#dt_options_div').hide();
                    jQuery('#json_div').hide();
                    jQuery('#value_div').hide();
                    jQuery('#template_div').hide();
                    jQuery('#url_link_div').hide();
                    break;
            }
        }

        function getValue(attr, value, errors) {
            if (value) {
                if (errors && value.indexOf('"') > -1) {
                    errors.push('<?php _e('Error: "', 'contact-form-7-to-database-extension'); ?>'
                                        + attr +
                                        '<?php _e('" should not contain double-quotes (")', 'contact-form-7-to-database-extension'); ?>');
                    value = value.replace('"', "'");
                }
                return attr + '="' + value + '"';
            }
            return '';
        }

        function getValueUrl(attr, value) {
            if (value) {
                return attr + '=' + encodeURIComponent(value)
            }
            return '';
        }


        function join(arr, delim) {
            if (delim == null) {
                delim = ' ';
            }
            var tmp = [];
            for (idx=0; idx<arr.length; idx++) {
                if (arr[idx] != '') {
                    tmp.push(arr[idx]);
                }
            }
            return tmp.join(delim);
        }

        function chopLastChar(text) {
            return text.substr(0, text.length - 1);
        }

        function createShortCode() {
            var scElements = [];
            var urlElements = [];
            var validationErrors = [];
            var shortcode = jQuery('#shortcode_ctrl').val();
            if (shortcode == '') {
                jQuery('#shortcode_result_text').html('');
                jQuery('#url_result_link').html('').attr('href', '#');
                return;
            }
            scElements.push(chopLastChar(shortcode));

            var formName = jQuery('#form_name_cntl').val();
            if (!formName) {
                validationErrors.push('<?php _e('Error: no form is chosen', 'contact-form-7-to-database-extension') ?>');
            }
            else {
                scElements.push('form="' + formName + '"');
                urlElements.push('form=' + encodeURIComponent(formName));
            }

            if (shortcode != '[cfdb-count]') {
                scElements.push(getValue('show', jQuery('#show_cntl').val(), validationErrors));
                urlElements.push(getValueUrl('show', jQuery('#show_cntl').val()));

                scElements.push(getValue('hide', jQuery('#hide_cntl').val(), validationErrors));
                urlElements.push(getValueUrl('hide', jQuery('#hide_cntl').val()));
            }

            var filter = getValue('filter', jQuery('#filter_cntl').val(), validationErrors);
            if (filter) {
                scElements.push(filter);
                urlElements.push(getValueUrl('filter', jQuery('#filter_cntl').val()));

                if (jQuery('#search_cntl').val()) {
                    validationErrors.push('<?php _e('Warning: "search" field ignored because "filter" is used (use one but not both)', 'contact-form-7-to-database-extension'); ?>');
                }
            }
            else {
                scElements.push(getValue('search', jQuery('#search_cntl').val(), validationErrors));
                urlElements.push(getValueUrl('search', jQuery('#search_cntl').val()));
            }

            if (shortcode != '[cfdb-count]') {
                var limitRows = jQuery('#limit_rows_cntl').val();
                var limitStart = jQuery('#limit_start_cntl').val();
                if (limitStart && !limitRows) {
                    validationErrors.push('<?php _e('Error: "limit": if you provide a value for "Start Row" then you must also provide a value for "Num Rows"', 'contact-form-7-to-database-extension'); ?>');
                }
                if (limitRows) {
                    if (! /^\d+$/.test(limitRows)) {
                        validationErrors.push('<?php _e('Error: "limit": "Num Rows" must be a positive integer', 'contact-form-7-to-database-extension'); ?>');
                    }
                    else {
                        var limitOption = ' limit="';
                        var limitOptionUrl = ' limit=';
                        if (limitStart) {
                            if (! /^\d+$/.test(limitStart)) {
                                validationErrors.push('<?php _e('Error: "limit": "Start Row" must be a positive integer', 'contact-form-7-to-database-extension'); ?>');
                            }
                            else {
                                limitOption += limitStart + ",";
                                limitOptionUrl += encodeURIComponent(limitStart + ",");
                            }
                        }
                        limitOption += limitRows;
                        limitOptionUrl += limitRows;
                        scElements.push(limitOption + '"');
                        urlElements.push(limitOptionUrl);
                    }
                }
                var orderByElem = getValue('orderby', jQuery('#orderby_cntl').val(), validationErrors);
                if (orderByElem) {
                    var orderByElemUrl = getValueUrl('orderby', jQuery('#orderby_cntl').val());
                    var orderByDir = jQuery('#orderbydir_cntl').val();
                    if (orderByDir) {
                        orderByElem = chopLastChar(orderByElem) + ' ' + orderByDir + '"';
                        orderByElemUrl = orderByElemUrl + encodeURIComponent(' ' + orderByDir);
                    }
                    scElements.push(orderByElem);
                    urlElements.push(orderByElemUrl);
                }
            }

            var scText;
            switch (shortcode) {
                case '[cfdb-html]':
                    scElements.push(getValue('filelinks', jQuery('#filelinks_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('filelinks', jQuery('#filelinks_cntl').val()));
                    scElements.push(getValue('wpautop', jQuery('#wpautop_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('wpautop', jQuery('#wpautop_cntl').val()));
                    var content = jQuery('#content_cntl').val();
                    urlElements.push('content=' + encodeURIComponent(content));
                    urlElements.push('enc=HTMLTemplate');
                    scText = join(scElements) + ']' + content + '[/cfdb-html]';
                    break;
                case '[cfdb-table]':
                    scElements.push(getValue('id', jQuery('#id_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('id', jQuery('#id_cntl').val()));
                    scElements.push(getValue('class', jQuery('#class_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('class', jQuery('#class_cntl').val()));
                    scElements.push(getValue('style', jQuery('#style_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('style', jQuery('#style_cntl').val()));
                    urlElements.push('enc=HTML');
                    scText = join(scElements) + ']';
                    break;
                case '[cfdb-datatable]':
                    scElements.push(getValue('id', jQuery('#id_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('id', jQuery('#id_cntl').val()));
                    scElements.push(getValue('class', jQuery('#class_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('class', jQuery('#class_cntl').val()));
                    scElements.push(getValue('style', jQuery('#style_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('style', jQuery('#style_cntl').val()));
                    scElements.push(getValue('dt_options', jQuery('#dt_options_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('dt_options', jQuery('#dt_options_cntl').val()));
                    urlElements.push('enc=DT');
                    scText = join(scElements) + ']';
                    break;
                case '[cfdb-value]':
                    scElements.push(getValue('function', jQuery('#function_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('function', jQuery('#function_cntl').val()));
                    scElements.push(getValue('delimiter', jQuery('#delimiter_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('delimiter', jQuery('#delimiter_cntl').val()));
                    urlElements.push('enc=VALUE');
                    scText = join(scElements) + ']';
                    break;
                case '[cfdb-count]':
                    urlElements.push('enc=COUNT');
                    scText = join(scElements) + ']'; // hopLastChar(scElements.join(' ')) + ']';
                    break;
                case '[cfdb-json]':
                    scElements.push(getValue('var', jQuery('#var_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('var', jQuery('#var_cntl').val()));
                    scElements.push(getValue('format', jQuery('#format_cntl').val(), validationErrors));
                    urlElements.push(getValueUrl('format', jQuery('#format_cntl').val()));
                    urlElements.push('enc=JSON');
                    scText = join(scElements) + ']';
                    break;
                case '[cfdb-export-link]':
                    scElements.push(getValue('enc', jQuery('#enc_cntl').val(), validationErrors));
                    urlElements.push(getValue('enc', jQuery('#enc_cntl').val()));
                    scElements.push(getValue('urlonly', jQuery('#urlonly_cntl').val(), validationErrors));
                    scText = join(scElements) + ']';
                    break;
                default:
                    scText = shortcode;
                    break;
            }
            jQuery('#shortcode_result_text').html(scText);

            var url = '<?php echo admin_url('admin-ajax.php') ?>?action=cfdb-export&';
            url += join(urlElements, '&');
            jQuery('#url_result_link').attr('href', url).html(url);
            jQuery('#validations_text').html(validationErrors.join('<br/>'));
        }

        var getFormFieldsUrlBase = '<?php echo $plugin->getFormFieldsAjaxUrlBase() ?>';
        function getFormFields() {
            jQuery('[id^=add]').attr('disabled', 'disabled');
            jQuery('[id^=btn]').attr('disabled', 'disabled');
            var formName = jQuery('#form_name_cntl').val();
            var url = getFormFieldsUrlBase + encodeURIComponent(formName);
            jQuery.getJSON(url, function(json) {
                var optionsHtml = '<option value=""></option>';
                jQuery(json).each(function() {
                    optionsHtml += '<option value="' + this + '">' + this + '</option>';
                });
                jQuery('[id^=add]').html(optionsHtml).removeAttr('disabled');
                jQuery('[id^=btn]').removeAttr('disabled');
            });
        }

        function addFieldToShow() {
            var value = jQuery('#show_cntl').val();
            if (value) {
                value += ',';
            }
            jQuery('#show_cntl').val(value + jQuery('#add_show').val());
            createShortCode();
        }

        function addFieldToHide() {
            var value = jQuery('#hide_cntl').val();
            if (value) {
                value += ',';
            }
            jQuery('#hide_cntl').val(value + jQuery('#add_hide').val());
            createShortCode();
        }

        function addFieldToOrderBy() {
            var value = jQuery('#orderby_cntl').val();
            if (value) {
                value += ',';
            }
            jQuery('#orderby_cntl').val(value + jQuery('#add_orderby').val());
            createShortCode();
        }

        function addFieldToFilter() {
            var value = jQuery('#filter_cntl').val();
            if (value) {
                value += jQuery('#filter_bool').val();
            }
            value += jQuery('#add_filter').val() + jQuery('#filter_op').val() + jQuery('#filter_val').val();
            jQuery('#filter_cntl').val(value);
            createShortCode();
        }

        function addFieldToContent() {
            jQuery('#content_cntl').val(jQuery('#content_cntl').val() + '${' + jQuery('#add_content').val() + '}');
        }

        function reset() {
            jQuery('#show_cntl').val('');
            jQuery('#hide_cntl').val('');
            jQuery('#search_cntl').val('');
            jQuery('#filter_cntl').val('');
            jQuery('#limit_rows_cntl').val('');
            jQuery('#limit_start_cntl').val('');
            jQuery('#orderby_cntl').val('');
            jQuery('#id_cntl').val('');
            jQuery('#class_cntl').val('');
            jQuery('#style_cntl').val('');
            jQuery('#dt_options_cntl').val('');
            jQuery('#var_cntl').val('');
            jQuery('#format_cntl').val('');
            jQuery('#function_cntl').val('');
            jQuery('#delimiter_cntl').val('');
            jQuery('#filelinks_cntl').val('');
            jQuery('#wpautop_cntl').val('');
            jQuery('#content_cntl').val('');
            jQuery('#enc_cntl').val('');
            jQuery('#urlonly_cntl').val('');
            createShortCode();
        }

        jQuery.ajaxSetup({
            cache: false
        });

        jQuery(document).ready(function() {
            showHideOptionDivs();
            createShortCode();
            jQuery('#shortcode_ctrl').change(showHideOptionDivs);
            jQuery('#shortcode_ctrl').change(createShortCode);
            jQuery('select[id$="cntl"]').change(createShortCode);
            jQuery('input[id$="cntl"]').keyup(createShortCode);
            jQuery('textarea[id$="cntl"]').keyup(createShortCode);
            jQuery('#form_name_cntl').change(getFormFields);
            jQuery('#btn_show').click(addFieldToShow);
            jQuery('#btn_hide').click(addFieldToHide);
            jQuery('#btn_orderby').click(addFieldToOrderBy);
            jQuery('#btn_filter').click(addFieldToFilter);
            jQuery('#btn_content').click(function() {
                addFieldToContent();
                createShortCode();
            });
            jQuery('#enc_cntl').click(createShortCode);
            jQuery('#urlonly_cntl').click(createShortCode);
            jQuery('#reset_button').click(reset);
        });


    </script>
    <style type="text/css">
        div.shortcodeoptions {
            border: #ccccff groove;
            margin-bottom: 10px;
            padding: 5px;
        }

        div.shortcodeoptions label {
            font-weight: bold;
            font-family: Arial sans-serif;
            margin-top: 5px;
        }

        #shortcode_result_div {
            margin-top: 1em;
        }

        .label_box {
            display: inline-block;
            min-width: 50px;
            padding-left: 2px;
            padding-right: 2px;
            border: 1px;
            margin-right: 5px;
        }
    </style>

    <div id="shortcode_result_div">
        <pre style="white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; white-space: pre-wrap; word-wrap: break-word;"><code id="shortcode_result_text"></code></pre>
    </div>
    <div id="url_result_link_div">
        <code><a target="_cfdb_export" href="#" id="url_result_link"></a></code>
    </div>
    <div id="validations_div">
        <span id="validations_text" style="background-color:#ffff66;"></span>
    </div>

    <h2>Short Code Builder</h2>
    <div style="margin-bottom:10px">
        <span>
            <div class="label_box"><label for="shortcode_ctrl">Short Code</label></div>
            <select name="shortcode_ctrl" id="shortcode_ctrl">
                <option value=""><?php _e('* Select a short code *', 'contact-form-7-to-database-extension') ?></option>
                <option value="[cfdb-html]">[cfdb-html]</option>
                <option value="[cfdb-table]">[cfdb-table]</option>
                <option value="[cfdb-datatable]">[cfdb-datatable]</option>
                <option value="[cfdb-value]">[cfdb-value]</option>
                <option value="[cfdb-count]">[cfdb-count]</option>
                <option value="[cfdb-json]">[cfdb-json]</option>
                <option value="[cfdb-export-link]">[cfdb-export-link]</option>
            </select>
        </span>
        <span style="margin-left:10px">
            <div class="label_box"><label for="form_name_cntl">form</label></div>
            <select name="form_name_cntl" id="form_name_cntl">
                <option value=""><?php _e('* Select a form *', 'contact-form-7-to-database-extension') ?></option>
                <?php foreach ($rows as $aRow) {
                $formName = $aRow->form_name;
                $selected = ($formName == $currSelection) ? "selected" : "";
                ?>
                <option value="<?php echo $formName ?>" <?php echo $selected ?>><?php echo $formName ?></option>
                <?php } ?>
            </select>
        </span>
        <span style="margin-left:10px">
            <button id="reset_button"><?php echo _e('Reset', 'contact-form-7-to-database-extension') ?></button>
        </span>
    </div>
    <div class="shortcodeoptions">
        <a id="doc_url_tag" target="_docs"
           href="http://cfdbplugin.com/?page_id=89"><?php _e('Documentation', 'contact-form-7-to-database-extension'); ?></a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size: x-small;">
            <a target="_docs"
               href="http://cfdbplugin.com/?page_id=444"><?php _e('(Did you know: you can create your own short code)', 'contact-form-7-to-database-extension'); ?></a>
        </span>
    </div>
    <div id="show_hide_div" class="shortcodeoptions">
        <?php _e('Which fields/columns do you want to display?', 'contact-form-7-to-database-extension'); ?>
        <div>
            <div class="label_box"><label for="show_cntl">show</label></div>
            <select name="add_show" id="add_show"></select><button id="btn_show"">&raquo;</button>
            <input name="show_cntl" id="show_cntl" type="text" size="100"/>
        </div>
        <div>
            <div class="label_box"><label for="hide_cntl">hide</label></div>
            <select name="add_hide" id="add_hide"></select><button id="btn_hide">&raquo;</button>
            <input name="hide_cntl" id="hide_cntl" type="text" size="100"/>
        </div>
    </div>
    <div id="filter_div" class="shortcodeoptions">
        <div><?php _e('Which rows/submissions do you want to display?', 'contact-form-7-to-database-extension'); ?></div>
        <div>
            <div class="label_box"><label for="search_cntl">search</label></div>
            <input name="search_cntl" id="search_cntl" type="text" size="30"/>
        </div>
        <div>
            <div class="label_box"><label for="filter_cntl">filter</label></div>
            <select name="filter_bool" id="filter_bool">
                <option value="&&">&&</option>
                <option value="||">||</option>
            </select>
            <select name="add_filter" id="add_filter"></select>
            <select name="filter_op" id="filter_op">
                <option value="=">=</option>
                <option value="!=">!=</option>
                <option value=">">></option>
                <option value="<"><</option>
                <option value="<="><=</option>
                <option value="<="><=</option>
                <option value="===">===</option>
                <option value="!==">!==</option>
                <option value="~~">~~</option>
            </select>
            <input name="filter_val" id="filter_val" type="text" size="10"/>
            <button id="btn_filter">&raquo;</button>
            <input name="filter_cntl" id="filter_cntl" type="text" size="100"/>
        </div>
    </div>
    <div id="limitorder_div" class="shortcodeoptions">
        <div>
            <div class="label_box"><label for="limit_rows_cntl">limit</label></div>
            Num Rows <input name="limit_rows_cntl" id="limit_rows_cntl" type="text" size="10"/>
            Start Row (0)<input name="limit_start_cntl" id="limit_start_cntl" type="text" size="10"/>
        </div>
        <div id="orderby_div">
            <div class="label_box"><label for="orderby_cntl">orderby</label></div>
            <select name="add_orderby" id="add_orderby"></select><button id="btn_orderby">&raquo;</button>
            <input name="orderby_cntl" id="orderby_cntl" type="text" size="100"/>
            <select id="orderbydir_cntl" name="orderbydir_cntl">
                <option value=""></option>
                <option value="ASC">ASC</option>
                <option value="DESC">DESC</option>
            </select>
        </div>
    </div>
    <div id="html_format_div" class="shortcodeoptions">
        <div><?php _e('HTML Table Formatting', 'contact-form-7-to-database-extension'); ?></div>
        <div>
            <div class="label_box"><label for="id_cntl">id</label></div>
            <input name="id_cntl" id="id_cntl" type="text" size="10"/>
        </div>
        <div>
            <div class="label_box"><label for="class_cntl">class</label></div>
            <input name="class_cntl" id="class_cntl" type="text" size="10"/>
        </div>
        <div>
            <div class="label_box"><label for="style_cntl">style</label></div>
            <input name="style_cntl" id="style_cntl" type="text" size="100"/>
        </div>
    </div>
    <div id="dt_options_div" class="shortcodeoptions">
        <div><?php _e('DataTable Options', 'contact-form-7-to-database-extension'); ?></div>
        <div class="label_box"><label for="dt_options_cntl">dt_options</label></div>
        <input name="dt_options_cntl" id="dt_options_cntl" type="text" size="100"/>
    </div>
    <div id="json_div" class="shortcodeoptions">
        <div><?php _e('JSON Options', 'contact-form-7-to-database-extension'); ?></div>
        <div>
            <div class="label_box"><label for="var_cntl">var</label></div>
            <input name="var_cntl" id="var_cntl" type="text" size="10"/>
        </div>
        <div>
            <div class="label_box"><label for="format_cntl">format</label></div>
            <select id="format_cntl" name="format_cntl">
                <option value=""></option>
                <option value="map">map</option>
                <option value="array">array</option>
                <option value="arraynoheader">arraynoheader</option>
            </select>
        </div>
    </div>
    <div id="value_div" class="shortcodeoptions">
        <div><?php _e('VALUE Options', 'contact-form-7-to-database-extension'); ?></div>
        <div>
            <div class="label_box"><label for="function_cntl">function</label></div>
            <select id="function_cntl" name="function_cntl">
                <option value=""></option>
                <option value="min">min</option>
                <option value="max">max</option>
                <option value="sum">sum</option>
                <option value="mean">mean</option>
                <option value="percent">percent</option>
            </select>
        </div>
        <div>
            <div class="label_box"><label for="delimiter_cntl">delimiter</label></div>
            <input name="delimiter_cntl" id="delimiter_cntl" type="text" size="10"/>
        </div>
    </div>
    <div id="template_div" class="shortcodeoptions">
        <div>
            <div class="label_box"><label for="filelinks_cntl">filelinks</label></div>
            <select id="filelinks_cntl" name="filelinks_cntl">
                <option value=""></option>
                <option value="url">url</option>
                <option value="name">name</option>
                <option value="link">link</option>
                <option value="img">img</option>
            </select>
            <div class="label_box"><label for="wpautop_cntl">wpautop</label></div>
            <select id="wpautop_cntl" name="wpautop_cntl">
                <option value=""></option>
                <option value="false">false</option>
                <option value="true">true</option>
            </select>
        </div>
        <div>
            <div class="label_box"><label for="content_cntl">Template</label></div>
            <select name="add_content" id="add_content"></select><button id="btn_content">&raquo;</button><br/>
            <textarea name="content_cntl" id="content_cntl" cols="100" rows="10"></textarea>
        </div>
    </div>
        <div id="url_link_div" class="shortcodeoptions">
            <div>
                <div class="label_box"><label for="enc_cntl">enc</label></div>
                <select id="enc_cntl" name="enc_cntl">
                    <option value=""></option>
                    <option id="CSVUTF8BOM" value="CSVUTF8BOM">
                        <?php _e('Excel CSV (UTF8-BOM)', 'contact-form-7-to-database-extension'); ?>
                    </option>
                    <option id="TSVUTF16LEBOM" value="TSVUTF16LEBOM">
                        <?php _e('Excel TSV (UTF16LE-BOM)', 'contact-form-7-to-database-extension'); ?>
                    </option>
                    <option id="CSVUTF8" value="CSVUTF8">
                        <?php _e('Plain CSV (UTF-8)', 'contact-form-7-to-database-extension'); ?>
                    </option>
                    <option id="IQY" value="IQY">
                        <?php _e('Excel Internet Query', 'contact-form-7-to-database-extension'); ?>
                    </option>
                </select>
            </div>
            <div>
                <div class="label_box"><label for="urlonly_cntl">urlonly</label></div>
                <select id="urlonly_cntl" name="urlonly_cntl">
                    <option value=""></option>
                    <option value="true">true</option>
                    <option value="false">false</option>
                </select>
            </div>
        </div>
    <?php

    }
}