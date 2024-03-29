<?php
/** no direct access **/
defined('_WPLEXEC') or die('Restricted access');

if($type == 'suggestion_search' and !$done_this)
{
?>
<div class="search-field-wp search-field-suggestion <?php echo (isset($value['enable']) ? $value['enable'] : ''); ?>" data-field-id="<?php echo $field->id; ?>" data-status="<?php echo (isset($value['enable']) ? $value['enable'] : ''); ?>" data-field-name="<?php echo __($field->name, 'wpl'); ?>">

	<input type="hidden" id="field_sort_<?php echo $field->id; ?>" name="<?php echo $this->get_field_name('data'); ?>[<?php echo $field->id; ?>][sort]" value="<?php echo (isset($value['sort']) ? $value['sort'] : ''); ?>" />
	<input type="hidden" id="field_enable_<?php echo $field->id; ?>" onchange="elementChanged(true);" name="<?php echo $this->get_field_name('data'); ?>[<?php echo $field->id; ?>][enable]" value="<?php echo (isset($value['enable']) ? $value['enable'] : ''); ?>" />
	
	<h4><span><?php echo __($field->name, 'wpl'); ?></span></h4>

	<div class="field-body">
		<div class="erow">
			<?php echo __('No Option Available', 'wpl'); ?>
		</div>
	</div>
</div>
<?php
    $done_this = true;
}