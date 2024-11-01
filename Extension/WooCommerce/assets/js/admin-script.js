jQuery(document).ready(function ($) {
    "use strict";


    $('.row-actions .edit a, .page-title-action, .column-title .row-title').on('click', function (e) {
        e.preventDefault();
        var id = 0;
        var modal = $('#oxi_woo_tabs_modal');
        var parent = $(this).parents('.column-title');

        modal.addClass('loading');
        modal.modal('show');
        if (parent.length > 0) {

            id = parent.find('.hidden').attr('id').split('_')[1];

            $.get(window.oxiwootabsultimate.restapi + 'woo_tabs_single_data', {id: id, _wpnonce: window.oxiwootabsultimate.nonce}, function (data) {
                OxiWooTabsEditor(data);
                modal.removeClass('loading');
            });
        } else {

            var data = {
                title: '',
                priority: 20,
                activation: 'yes',
                condition: 'entire_site',
                singular_id: '',
                archive: 'products_cat',
                products_cat: '',
                products_tags: '',

            };
            OxiWooTabsEditor(data);
            modal.removeClass('loading');
        }
        var url = modal.attr('data-editor-url') + 'post.php?post=' + id + '&action=edit';
        $('.open-data-btn-editor').attr('data-editor-url', url);
        $('#oxi-woo-tabs-id').val(id);




    });

    function ShortcodeCcontrolTabsSelect() {
        var oxi_woo_tabs_c = $('.oxi_woo_tabs_c').val();

        if (oxi_woo_tabs_c == 'singular') {
            $('.oxi_woo_tabs_singular_id-container').show();
            $('.oxi_woo_tabs_archive-container').hide();
            $('.oxi_woo_tabs_archive_author_id-container').hide();
            $('.oxi_woo_tabs_archive_cat_id-container').hide();
            $('.oxi_woo_tabs_archive_tags_id-container').hide();
        } else if (oxi_woo_tabs_c == 'archive') {
            $('.oxi_woo_tabs_singular_id-container').hide();
            $('.oxi_woo_tabs_archive-container').show();
            var condition = $('.oxi_woo_tabs_archive').val();
            if (condition == 'products_cat') {
                $('.oxi_woo_tabs_archive_author_id-container').hide();
                $('.oxi_woo_tabs_archive_cat_id-container').show();
                $('.oxi_woo_tabs_archive_tags_id-container').hide();
            } else if (condition == 'products_tags') {
                $('.oxi_woo_tabs_archive_author_id-container').hide();
                $('.oxi_woo_tabs_archive_cat_id-container').hide();
                $('.oxi_woo_tabs_archive_tags_id-container').show();
            }
        } else {
            $('.oxi_woo_tabs_singular_id-container').hide();
            $('.oxi_woo_tabs_archive-container').hide();
            $('.oxi_woo_tabs_archive_author_id-container').hide();
            $('.oxi_woo_tabs_archive_cat_id-container').hide();
            $('.oxi_woo_tabs_archive_tags_id-container').hide();

        }
    }
    ;

    $('.shortcode-control-type-text select').on('change', function () {
        ShortcodeCcontrolTabsSelect();
    });


    $('.open-data-btn-editor').on('click', function () {
        var link = $(this).attr('data-editor-url');
        window.location.href = link;
    });

    $('#oxi_woo_tabsinput-form').on('submit', function (e) {
        e.preventDefault();
        var modal = $('#addons_headerfooter_modal');
        modal.addClass('loading');
        var form_data = $(this).serialize();

        $.get(window.oxiwootabsultimate.restapi + 'tabsupdate/', form_data, function (output) {
            location.reload();
        });

    });

    $('.oxi_woo_tabs_singular_id').select2({
        ajax: {
            url: window.oxiwootabsultimate.restapi + 'woo_product_name',
            dataType: 'json',
            data: function (params) {
                var query = {
                    qu: params.term,
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
                return query;
            }
        },
        width: '100%',
        cache: true,
        placeholder: "--",
    });

    $('.oxi_woo_tabs_archive_cat_id').select2({
        ajax: {
            url: window.oxiwootabsultimate.restapi + 'woo_cat_name',
            dataType: 'json',
            data: function (params) {
                var query = {
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
                return query;
            }
        },
        width: '100%',
        cache: true,
        placeholder: "--",
    });

    $('.oxi_woo_tabs_archive_tags_id').select2({
        ajax: {
            url: window.oxiwootabsultimate.restapi + 'woo_tag_name',
            dataType: 'json',
            data: function (params) {
                var query = {
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
                return query;
            }
        },
        width: '100%',
        cache: true,
        placeholder: "--",
    });

    function OxiWooTabsEditor(data) {




        $('.oxi_woo_tabsinput-title').val(data.title);
        $('.oxi_woo_tabsinput-priority').val(data.priority);
        $('.oxi_woo_tabs_c').val(data.condition).change();

        $('.oxi_woo_tabs_archive').val(data.archive).change();
        var activation_input = $('.oxi_woo_tabsinput-activition');
        if (data.activation == 'yes') {
            activation_input.attr('checked', true);
        } else {
            activation_input.removeAttr('checked');
        }

        $('.oxi_woo_tabsinput-activition,  .oxi_woo_tabsinput-priority').trigger('change');


        ShortcodeCcontrolTabsSelect();


        if (data.singular_id !== null && data.singular_id.length > 0) {
            console.log(data.singular_id.length);
            var el = $('.oxi_woo_tabs_singular_id');
            $.ajax({
                url: window.oxiwootabsultimate.restapi + 'woo_product_name',
                dataType: 'json',
                data: {
                    ids: String(data.singular_id),
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
            }).then(function (data) {

                if (data !== null && data.results.length > 0) {
                    el.html(' ');
                    $.each(data.results, function (i, v) {
                        var option = new Option(v.text, v.id, true, true);
                        el.append(option).trigger('change');
                    });
                    el.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                }
            });
        } else {
            $('.oxi_woo_tabs_singular_id').val(null).trigger('change');
        }



        if (data.products_cat !== null && data.products_cat.length > 0) {

            var el = $('.oxi_woo_tabs_archive_cat_id');
            $.ajax({
                url: window.oxiwootabsultimate.restapi + 'woo_cat_name',
                dataType: 'json',
                data: {
                    ids: String(data.products_cat),
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
            }).then(function (data) {

                if (data !== null && data.results.length > 0) {
                    el.html(' ');
                    $.each(data.results, function (i, v) {
                        var option = new Option(v.text, v.id, true, true);
                        el.append(option).trigger('change');
                    });
                    el.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                }
            });
        }
        if (data.products_tags !== null && data.products_tags.length > 0) {
            var el = $('.oxi_woo_tabs_archive_tags_id');
            $.ajax({
                url: window.oxiwootabsultimate.restapi + 'woo_tag_name',
                dataType: 'json',
                data: {
                    ids: String(data.products_tags),
                    _wpnonce: window.oxiwootabsultimate.nonce
                }
            }).then(function (data) {

                if (data !== null && data.results.length > 0) {
                    el.html(' ');
                    $.each(data.results, function (i, v) {
                        var option = new Option(v.text, v.id, true, true);
                        el.append(option).trigger('change');
                    });
                    el.trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                }
            });
        }
       
    }








});