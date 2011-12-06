<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

//print_r($_POST);
$id_torneo_file = fopen('ID_TORNEO.txt', 'r');
$id_torneo_scelto = fscanf($id_torneo_file, '%u');
//print_r($id_torneo_scelto);
fclose($id_torneo_file);

$id_torneo = $id_torneo_scelto[0];

//echo('Id del torneo = '.JRequest::getVar('idtorneoscelto'));
//echo('setvar: '.JRequest::getVar('id_torneo_SETVAR'));
//echo('id torneo file: '.$id_torneo);
?>
<form action="<?php echo JRoute::_('index.php?option=com_sancamanager&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="giornate-form">
    <?php
        foreach($this->form->getFieldsets() as $field_name) {
            ?>
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_SANCAMANAGER_GIORNATE_'.$field_name->name); ?></legend>
		<ul class="adminformlist">
<?php foreach($this->form->getFieldset($field_name->name) as $field): ?>
			<li><?php echo $field->label;echo $field->input; ?></li>
<?php endforeach; ?>
		</ul>
                <script>
                    function miaFuncStart() {
                        document.getElementById('jform_id_torneo').setAttribute('value', <?php echo($id_torneo); ?>);
                    }
                function addLoadEvent(func){
                  var oldonload = window.onload;
                  if (typeof window.onload != 'function'){
                      window.onload = func;
                  } else {
                    window.onload = function(){
                    oldonload();
                    func();
                }}}addLoadEvent(miaFuncStart);
                </script>
	</fieldset>
       <?php
        }
        ?>
    <div id="dettagli_incontri">
         <?php
         $id_giornata = $this->item->id;
         $db = JFactory::getDbo();
         
         // selezioniamo gli incontri della giornata
         $query = $db->getQuery(true);
         $query->select('*');
         $query->from('#__sm_incontri');
         $query->where('id_giornata = '.$id_giornata);
         
         $db->setQuery((string)$query);
         $incontri = $db->loadObjectList();
         
         $num_incontri = count($incontri);
         // selezioniamo le squadre del torneo della giornata
         $query = $db->getQuery(true);
         $query->select('*');
         $query->from('#__sm_giornate AS a');
         $query->join('LEFT', '#__sm_tornei AS b ON a.id_torneo = b.id');
         $query->where('id_giornata = '.$id_giornata);
         
         $db->setQuery((string)$query);
         $info_torneo = $db->loadObjectList();
         
         // prendiamo i nomi delle squadre
         $query = $db->getQuery(true);
         $query->select('*');
         $query->from('#__sm_tornei');
         $query->where('id = '.$id_torneo);
         
         $db->setQuery((string)$query);
         $torneo = $db->loadObjectList();
         
         //print_r($torneo);
         
         $squadre = array();
         if ($torneo) {
             //echo($info_torneo->ids_squadre);
             $squadre = explode(',',$torneo[0]->ids_squadre);
         }
         
         //print_r($squadre);
         
         $num_squadre = count($squadre);
         
         // prendiamo i nomi delle squadre
         $query = $db->getQuery(true);
         $query->select('*');
         $query->from('#__sm_squadre_tornei');
         
         $db->setQuery((string)$query);
         $nomi_squadre = $db->loadObjectList();
         
         $squadre_torneo = array();
         if ($nomi_squadre) {
             foreach ($nomi_squadre as $nome_squadra) {
                 if (in_array($nome_squadra->id, $squadre)) {
                     $squadre_torneo[$nome_squadra->id] = $nome_squadra->nome;
                 }
             }
         }
        
         ?>
        <script>
        var squadre = new Object();
        <?php
        foreach ($squadre_torneo as $s_key => $s) {
            echo('squadre["'.$s_key.'"] = "'.$s.'";');
        }
                ?>
            
        var num_incontri = <?php echo($num_incontri); ?>;
        
        function append_squadre_to_select(select_object, squadre) {
            for (var id_squadra in squadre)
                select_object.options[select_object.options.length] = new Option(squadre[id_squadra], id_squadra);
        }
        
        function rimuovi_incontro() {
            if (num_incontri > 0) {
                document.getElementById('incontri_giornata').removeChild(document.getElementById('incontro_'+num_incontri));
                num_incontri--;
                document.getElementById('num_matches').value = num_incontri;
                //alert(document.getElementById('num_matches').value);
            }
        }
        
        function aggiungi_incontro() {
            num_incontri++;
            var div_nuovo_incontro = document.createElement('div');
            
            div_nuovo_incontro.setAttribute('id', 'incontro_'+num_incontri);
            div_nuovo_incontro.setAttribute('style', 'clear: both');
            
            var text_numero_incontro = document.createElement('label');
            text_numero_incontro.textContent = 'Incontro '+num_incontri;
            
            var select_squadra1 = document.createElement('select');
            select_squadra1.setAttribute('id', 'squadra1_incontro'+num_incontri);
            select_squadra1.setAttribute('name', 'squadra1_incontro'+num_incontri);
            append_squadre_to_select(select_squadra1, squadre);
            var text_reti_squadra1 = document.createElement('input');
            text_reti_squadra1.setAttribute('type', 'text');
            text_reti_squadra1.setAttribute('name', 'reti_squadra1_incontro'+num_incontri);
            text_reti_squadra1.setAttribute('size', '4');
            
            //var text_separator = document.createTextNode(' - ');
            
            var text_reti_squadra2 = document.createElement('input');
            text_reti_squadra2.setAttribute('type', 'text');
            text_reti_squadra2.setAttribute('name', 'reti_squadra2_incontro'+num_incontri);
            text_reti_squadra2.setAttribute('size', '4');
            
            var select_squadra2 = document.createElement('select');
            select_squadra2.setAttribute('id', 'squadra2_incontro'+num_incontri);
            select_squadra2.setAttribute('name', 'squadra2_incontro'+num_incontri);
            append_squadre_to_select(select_squadra2, squadre);
            
            var text_data_incontro = document.createElement('input');
            text_data_incontro.setAttribute('type', 'text');
            text_data_incontro.setAttribute('name', 'data_incontro'+num_incontri);
            var text_ora_incontro = document.createElement('input');
            text_ora_incontro.setAttribute('type', 'text');
            text_ora_incontro.setAttribute('name', 'ora_incontro'+num_incontri);
            var text_luogo_incontro = document.createElement('input');
            text_luogo_incontro.setAttribute('type', 'text');
            text_luogo_incontro.setAttribute('name', 'luogo_incontro'+num_incontri);
            
                var div_spacer = document.createElement('div');
                div_spacer.setAttribute('style', 'clear: both');
            
            div_nuovo_incontro.appendChild(text_numero_incontro);
            div_nuovo_incontro.appendChild(select_squadra1);
            div_nuovo_incontro.appendChild(text_reti_squadra1);
            //div_nuovo_incontro.appendChild(text_separator);
            div_nuovo_incontro.appendChild(text_reti_squadra2);
            div_nuovo_incontro.appendChild(select_squadra2);
            div_nuovo_incontro.appendChild(text_data_incontro);
            div_nuovo_incontro.appendChild(text_ora_incontro);
            div_nuovo_incontro.appendChild(text_luogo_incontro);
            div_nuovo_incontro.appendChild(div_spacer);
            
            var nuovo_li = document.createElement('li');
            nuovo_li.appendChild(div_nuovo_incontro);
            
            document.getElementById('incontri_giornata').appendChild(div_nuovo_incontro);
            
            document.getElementById('num_matches').value = num_incontri;
            
            //alert(document.getElementById('num_matches').value);
        }
        </script>
        <fieldset class="adminform">
            <legend>Incontri della giornata</legend>
            <div id="incontri_giornata">
        <?php
        $i_count = 0;
        if ($incontri) {
            foreach ($incontri as $incontro) {
                $i_count++;
                ?>
                <div id="incontro_<?php echo $i_count; ?>" style="clear:both">
                    <label>Incontro <?php echo($i_count); ?></label>
                    <select id="squadra1_incontro<?php echo($i_count); ?>" name="squadra1_incontro<?php echo($i_count); ?>">
                        <?php
                        foreach ($squadre_torneo as $s_key => $s) {
                            echo('<option value="'.$s_key.'" ');
                            if ($incontro->id_squadra1 == $s_key)
                                    echo('selected="selected"');
                            echo('>'.$s.'</option>');
                        }
                        ?>
                    </select>
                    <input type="text" value="<?php echo($incontro->reti_squadra1); ?>" name="reti_squadra1_incontro<?php echo($i_count); ?>" size="4" />
                    <input type="text" value="<?php echo($incontro->reti_squadra2); ?>" name="reti_squadra2_incontro<?php echo($i_count); ?>" size="4" />
                    <select id="squadra2_incontro<?php echo($i_count); ?>" name="squadra2_incontro<?php echo($i_count); ?>">
                        <?php
                        foreach ($squadre_torneo as $s_key => $s) {
                            echo('<option value="'.$s_key.'" ');
                            if ($incontro->id_squadra2 == $s_key)
                                    echo('selected="selected"');
                            echo('>'.$s.'</option>');
                        }
                        ?>
                    </select>
                    <input type="text" name="data_incontro<?php echo($i_count); ?>" value="<?php echo($incontro->data); ?>" />
                    <input type="text" name="ora_incontro<?php echo($i_count); ?>" value="<?php echo($incontro->ora); ?>" />
                    <input type="text" name="luogo_incontro<?php echo($i_count); ?>" value="<?php echo($incontro->luogo); ?>" />
                </div>
                <?php
            }
        }
        // inseriamo ora i moduli vuoti per inserire un nuovo incontro
        ?>            
        </div>
        <div id="buttons">
            <input type="button" value="Aggiungi incontro" onclick="aggiungi_incontro();" />
            <input type="button" value="Rimuovi incontro" onclick="rimuovi_incontro();" />
            <input type="hidden" value="<?php echo($num_incontri); ?>" id="num_matches" name="num_incontri_giornata" />
        </div>
       </fieldset>
    </div>
	<div>
		<input type="hidden" name="task" value="giornate.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
    <?php
    // ricordiamoci se abbiamo appena inserito una nuova giornata o aggiornato una giornata preesistente
    if (!isset($_GET['id']))
        $isNew = true;
    else if (isset($_GET['id']) && $_GET['id'] == 0)
        $isNew = true;
    else
        $isNew = false;

     $f = fopen("nuova_giornata.txt", "w+");

    if ($isNew)
        fprintf($f, "%u-%u", 1, 0);
    else
        fprintf($f, "%u-%u", 0, $_GET['id']);

    fclose($f);
    ?>
</form>