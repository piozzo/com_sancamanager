<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_sancamanager&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="squadretornei-form">
    <?php
        foreach($this->form->getFieldsets() as $field_name) {
            ?>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_SANCAMANAGER_SQUADRETORNEI_'.$field_name->name); ?></legend>
		<ul class="adminformlist">
<?php foreach($this->form->getFieldset($field_name->name) as $field): ?>
			<li><?php echo $field->label;echo $field->input;?></li>
<?php endforeach; ?>
		</ul>
	</fieldset>
       <?php
        }
        ?>
	<div>
		<input type="hidden" name="task" value="squadretornei.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>