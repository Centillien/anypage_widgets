<?php
/**
 * Edit / add a page
 */
myvox_load_js('lightbox');
myvox_load_css('lightbox');

extract($vars);

$is_walled_garden = myvox_get_config('walled_garden');

$desc_class = $render_type != 'html' ? 'class="hidden"' : '';
$view_info_class = $render_type != 'view' ? 'class="hidden"' : '';
$layout_class = $render_type == 'view' ? 'class="hidden"' : '';

$visible_check = $visible_through_walled_garden ? 'checked="checked"' : '';
if ($is_walled_garden) {
	$requires_login_check = 'checked="checked"';
} else {
	$requires_login_check = $requires_login ? 'checked="checked"' : '';
}

$show_in_footer_check = $show_in_footer ? 'checked="checked"' : '';

$layout_options = AnyPage::getLayoutOptions();

?>
<div>
	<label><?php echo myvox_echo('title'); ?></label><br />
	<?php
	echo myvox_view('input/text', array(
		'name' => 'title',
		'value' => $title
	));
	?>
</div>

<div>
	<label><?php echo myvox_echo('anypage:path'); ?></label><br />
	<?php
	echo myvox_view('input/text', array(
		'name' => 'page_path',
		'value' => $page_path,
		'id' => 'anypage-path'
	));

	// display any path conflicts
	?><div id="anypage-notice"><?php
	if ($entity) {
		echo AnyPage::viewPathConflicts($entity->getPagePath(), $entity);
	}
	?></div><?php

	echo myvox_echo('anypage:path_full_link') . ': ';
	echo myvox_view('output/url', array(
		'href' => $entity ? $entity->getPagePath() : '',
		'text' => myvox_normalize_url($entity ? $entity->getPagePath() : ''),
		'class' => 'anypage-updates-on-path-change'
	));
	?>
</div>

<div>
<?php if ($is_walled_garden) { ?>
	<label>
		<input type="checkbox" name="visible_through_walled_garden"
			   value="1" <?php echo $visible_check; ?> />
		<?php echo myvox_echo('anypage:visible_through_walled_garden'); ?>
	</label>
	<br />

	<label class="myvox-quiet">
		<input type="checkbox" name="requires_login" value="1"
			<?php echo $requires_login_check; ?> disabled="disabled"/>
		<?php echo myvox_echo('anypage:requires_login'); ?>
	</label>
<?php } else { ?>
	<label class="myvox-quiet">
		<input type="checkbox" name="visible_through_walled_garden"
			   value="1" <?php echo $visible_check; ?> disabled="disabled"/>
		<?php echo myvox_echo('anypage:visible_through_walled_garden:disabled'); ?>
	</label>
	<br />

	<label>
		<input type="checkbox" name="requires_login" value="1"
			<?php echo $requires_login_check; ?> />
		<?php echo myvox_echo('anypage:requires_login'); ?>
	</label>
<?php } ?>
</div>

<div>
	<label>
	<input type="checkbox" name="show_in_footer" value="1" <?php echo $show_in_footer_check; ?> />
	<?php
		echo myvox_echo('anypage:show_in_footer');
	?>
	</label>
</div>

<div>
	<label>
	<?php
		echo myvox_view('input/dropdown', array(
			'name' => 'render_type',
			'id' => 'anypage-render-type',
			'options_values' => array(
				'html' => myvox_echo('anypage:use_editor'),
				'view' => myvox_echo('anypage:use_view'),
			),
			'value' => $render_type
		));
	?>
	</label>
</div>

<div id="anypage-layout" class="<?php echo $layout_class;?>">
	<label>
		<?php echo myvox_echo('anypage:layout'); ?>:

		<?php
			echo myvox_view('input/dropdown', array(
				'options_values' => $layout_options,
				'name' => 'layout',
				'class' => 'anypage-layout',
				'value' => $layout
			));
		?>

		<span class="myvox-text-help myvox-quiet">
			<?php echo myvox_echo('anypage:layout:help'); ?>
		</span>
	</label>
</div>

<div id="anypage-view-info" <?php echo $view_info_class;?>>
	<p>
	<?php
	echo '<p>' . myvox_echo('anypage:view_info');
	echo " anypage<span class=\"anypage-updates-on-path-change\">$page_path</span>";
	echo '</p>';
	?>
	</p>
</div>

<div id="anypage-description" <?php echo $desc_class;?>>
	<label><?php echo myvox_echo('anypage:body'); ?></label><br />
	<?php
	echo myvox_view('page/layouts/widgets/add_button');
	echo myvox_view('input/longtext', array(
		'name' => 'description',
		'value' => $description
	));
	?>
</div>

<div class="myvox-foot">
<?php

if ($guid) {
	echo myvox_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	echo myvox_view('output/confirmlink', array(
		'class' => 'float myvox-button myvox-button-action',
		'text' => myvox_echo('delete'),
		'href' => 'action/anypage/delete?guid=' . $guid
	));
}

echo myvox_view('input/submit', array(
	'value' => myvox_echo("save"),
	'class' => 'float-alt myvox-button myvox-button-action'
	));

?>
</div>
<div class="anypage_widgets_panel">
	<?php
	echo myvox_view('page/layouts/widgets/add_panel', array(
		'context' => 'index'
	));
	?>
</div>
