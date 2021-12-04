
/**
 * First we will load all of this project's JavaScript dependencies
 */

require('./bootstrap');

$(document).ready(function () {
    // radio buttons
    var last_radio = '';
    $('input:radio').each(function () {
        if ($(this).parent().parent().hasClass('radio-inline')) {
            input_name    = $(this).attr("name");
            input_value   = $(this).attr("value");
            input_text    = $(this).text();
            input_checked = $(this).is(':checked');

            enable_class  = 'btn-default';
            disable_class = 'btn-default';

            if (last_radio == input_name) {
                return;
            }

            last_radio = input_name;

            if ($(':radio[name="' + input_name + '"]').length != 2) {
                return;
            }

            if ((input_value != 0) && (input_value != 1)) {
                return;
            }

            if ((input_text.localeCompare(text_yes) == 1) && (input_text.localeCompare(text_no) == 1)) {
                return;
            }

            if (input_value == 1 && input_checked == true) {
                enable_class = 'btn-success active';
            } else {
                disable_class = 'btn-danger active';
            }

            $('#' + input_name + '_1').removeClass('btn-default').addClass(enable_class);
            $('#' + input_name + '_0').removeClass('btn-default').addClass(disable_class);
        }
    });

    // label click check
    $(document).on('click', '.btn-group label:not(.active)', function (e) {
        disable_label = $(this);
        disable_input = $('#' + disable_label.attr('id') + ' :input');

        if (disable_input.attr('type') != 'radio') {
            return;
        }

        if (!disable_input.is(':checked')) {
            enable_input = $('input[name="' + disable_input.attr('name') + '"]:checked');
            enable_label = enable_input.parent();

            enable_label.removeClass('btn-success active');
            enable_label.removeClass('btn-danger active');

            enable_input.removeAttr('checked');
            enable_label.addClass('btn btn-default');

            disable_label.removeClass('btn-default');

            if (disable_input.val() == 0) {
                disable_label.addClass('btn-danger active');
            } else {
                disable_label.addClass('btn-success active');
            }

            disable_input.attr('checked', 'checked');

            enable_input.trigger('change');
            disable_input.trigger('change');
        }
    });

    $('.button-submit').click(function() {
        var btn = $(this);
        var original = $(this).html();
        if (btn.data("loading-text")) {
            btn.html('<i class="fa fa-spinner fa-spin"></i> ' + btn.data("loading-text"));
        } else {
            btn.html('<i class="fa fa-spinner fa-spin"></i>');
        }

        setTimeout(function() {
            btn.html(original);
        }, 6000);
    });
});
