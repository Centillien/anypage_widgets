myvox.provide('myvox.anypage_widgets');

myvox.anypage_widgets.init = function() {
    if ($('.anypage_widgets_panel').length >= 1) {
        $('.myvox-state-available > .myvox-button-submit').each(function() {
            var handler = $(this).parent().attr('id').replace('myvox-widget-type-', '');

            $(this).addClass('myvox-lightbox').attr('href', '/ajax/view/anypage_widgets/wizard?widget=' + handler);
        });

        myvox.ui.lightbox_init();

        $(document).on('change keyup', '.widget-param', function() {
            var widgetGuid = $('input[name="widget"]').val();;
            var params = '';

            $('.widget-param').each(function() {
                if ($(this).val().length == 0) {
                    return;
                }

                if ($(this).data('default') == $(this).val()) {
                    return;
                }

                var param = $(this).attr('name').replace('-', '|');

                params += param + '|' + $(this).val() + ':';
            });

            if (params.length != 0) {
                params = ':' + params;

                params = params.slice(0, -1);
            }

            $('input[name="widget-result"]').val('[WIDGET:' + widgetGuid + params + ']');
        });
    }
};

myvox.register_hook_handler('init', 'system', myvox.anypage_widgets.init);
