<?php

global $CONFIG;

admin_gatekeeper();

$handler = myvox_extract('widget', $_GET, null);

if ($handler == null) {
    forward('', 404);
}

if (!isset($CONFIG->widgets->handlers[$handler])) {
    forward('', 404);
}

$widgetGuid = myvox_create_widget(myvox_get_logged_in_user_guid(), $handler, 'all');
?>
<div style="width: 400px;">
    <?php
    echo myvox_view('page/elements/title', array(
        'title' => myvox_echo('anypage_widgets:title')
    ));

    echo myvox_view('input/hidden', array(
        'name' => 'widget',
        'value' => $widgetGuid
    ));

    echo '<p>' . myvox_echo('anypage_widgets:description') . '</p>';

    echo myvox_view('input/text', array(
        'name' => 'widget-result',
        'value' => '[WIDGET:' . $widgetGuid . ']',
        'style' => 'width: 350px;',
        'readonly' => 'yes'
    ));
    ?>

    <fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
        <legend><?= myvox_echo('anypage_widgets:title:style'); ?></legend>

        <?php
        echo myvox_echo('anypage_widgets:input:style:height');

        echo myvox_view('input/text', array(
            'name' => 'style-height',
            'class' => 'widget-param'
        ));

        echo myvox_echo('anypage_widgets:input:style:width');
        echo myvox_view('input/text', array(
            'name' => 'style-width',
            'class' => 'widget-param'
        ));

        echo myvox_echo('anypage_widgets:input:style:float') . '<br/>';
        echo myvox_view('input/dropdown', array(
            'name' => 'style-float',
            'options' => array(
                'left',
                'right'
            ),
            'class' => 'widget-param',
            'data-default' => 'left'
        ));
        ?>
    </fieldset>
</div>