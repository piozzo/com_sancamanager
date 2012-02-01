<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from('#__sm_tornei');
$db->setQuery((string)$query);

$tornei_list = $db->loadObjectList();
?>
<script>
function submit_id_torneo() {
    //document.getElementById('form_giornate').action = document.getElementById('form_giornate').action + '&layout=listagiornate';
    document.getElementById('form_giornate').submit();
}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_sancamanager&view=giornates'); ?>" method="post" name="adminForm" id="form_giornate">
    <?php
    //print_r($_POST);
    if (!isset($_POST['id_torneo_per_giornate'])) {
        //echo('Id torneo non settato!');
        $id_torneo_selezionato = 0;
    ?>
    <div>Scegli il torneo:
        <select id="id_torneo_per_giornate" name="id_torneo_per_giornate">
           <?php
            if ($tornei_list) {
                foreach ($tornei_list as $torneo) {
                    echo('<option value="'.$torneo->id.'">'.$torneo->descrizione.'</option>');
                }
            }
            ?>
        </select>
        <input type="button" value="Seleziona il torneo" onclick="submit_id_torneo();" />
    </div>
    <?php
    }
    else {
        $id_torneo = $_POST['id_torneo_per_giornate'];
        JRequest::setVar('id_torneo_selezionato', $id_torneo);
        JRequest::setVar('id_torneo_SETVAR', $id_torneo);
        //$id_torneo = $_POST['id_torneo_per_giornate'];
        //$id_torneo_selezionato = $id_torneo;

        // salviamo l'id del torneo selezionato in un file
        $id_torneo_file = fopen('ID_TORNEO.txt', 'w+');
        fprintf($id_torneo_file,'%u', $id_torneo);
        fclose($id_torneo_file);

        
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__sm_giornate');
        $query->where('id_torneo = '.$id_torneo);
        
        //$db->setQuery((string)$query);
        //$this->items = $db->loadObjectList();
        
        //echo ($query);
    ?>
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
        <!-- <input type="hidden" name="idtorneoscelto" value="<?php //echo($id_torneo); ?>" /> -->
    <?php
        JRequest::setVar('idtorneoscelto', $id_torneo);
    }
    ?>
    <div>
		<input type="hidden" name="task" value="giornate" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>