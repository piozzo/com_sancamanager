<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="5">
		<?php echo JText::_('COM_SANCAMANAGER_STAGIONISPORTIVE_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_TORNEI_HEADING_DESCRIZIONE'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_TORNEI_HEADING_CATEGORIA_SPORTIVA'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_TORNEI_HEADING_STAGIONE_SPORTIVA'); ?>
    </th>
</tr>