<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$id_torneo = JRequest::getVar('id_torneo_selezionato');
//if (!isset($_POST['id_torneo_selezionato'])) 
//    $id_torneo = 0;
//else
//    $id_torneo = $_POST['id_torneo_selezionato'];

$db = JFactory::getDbo();

$query = $db->getQuery(true);
$query->select('*');
$query->from('#__sm_tornei');
$query->where('id = '.$id_torneo);

$db->setQuery((string)$query);
$tornei = $db->loadObjectList();

$desc_torneo = $tornei[0]->descrizione;

?>
<div class="pagetitle" align="center">
    <h2><?php echo($desc_torneo); ?></h2>
</div>
<tr>
	<th width="5">
		<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_ID'); ?>
	</th>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_NOME'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_DATA'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_ORA'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_DESCRIZIONE'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_SANCAMANAGER_GIORNATE_HEADING_TORNEO'); ?>
    </th>
</tr>