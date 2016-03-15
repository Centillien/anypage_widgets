<?php
/**
 * Any page default view
 */
$page = myvox_extract('entity', $vars);

echo myvox_view_title($page->title);
echo anypage_widgets_convert($page->description);