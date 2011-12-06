<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

if (!(JFactory::getUser()->id > 0))
        die('FURBONE! DOVE VUOI ANDARE? PUSSA VIA! :P');

JHTML::stylesheet('stile.css', 'components/com_sancamanager/css/' );

$db =& JFactory::getDbo();

$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

//echo('Utente collegato: '.JFactory::getUser()->username) ;

if (JRequest::getVar('salvataggio_risultati')) {
    $num_giornate = JRequest::getVar('numero_giornate');
    $num_incontri = array();
    $num_incontri = unserialize(JRequest::getVar('numero_incontri'));
    //echo('njumero giornte: '.$num_giornate);
    //print_r($num_incontri);
    
    for ($i = 1; $i <= $num_giornate; $i++) {
        $n_incontri = $num_incontri[$i];
        //echo('numero incontri: '.$n_incontri);
        for ($j = 1; $j <= $n_incontri; $j++) {
            $id_incontro = JRequest::getVar('idincontro'.$j.'giornata'.$i);
            $reti_squadra1 = JRequest::getVar('reti_squadra1_incontro'.$j.'_giornata'.$i);
            $reti_squadra2 = JRequest::getVar('reti_squadra2_incontro'.$j.'_giornata'.$i);
            
            $query = $db->getQuery(true);
            $query->update('#__sm_incontri');
            $query->set('reti_squadra1 = '.($reti_squadra1== ''? 'NULL' : $reti_squadra1).', reti_squadra2 = '.($reti_squadra2== ''? 'NULL' : $reti_squadra2));
            $query->where('id = '.$id_incontro);
            
            $db->setQuery((string)$query);
            $result = $db->query();
            
            if (!$result) {
                echo((string)$query);
                die('error in updating match results');
            }
        }
    }
    ?>
<div align="center">Dati aggiornati correttamente</div>
<?php
}

if (JRequest::getVar('torneo_selezionato') > 0) {
    $id_torneo = JRequest::getVar('torneo_selezionato');
    
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_giornate');
    $query->where('id_torneo = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $giornate = $db->loadObjectList();
    
    $numero_giornate = count($giornate);
    
    // Ottiene un array di colonne
    foreach ($giornate as $key => $giornata) {
        $id[$key]  = $giornata->id;
        $data[$key] = substr($giornata->data,6,4).'-'.substr($giornata->data,3,2).'-'.substr($giornata->data,0,2);
    }

    // Ordina 'volume' in senso discendente, 'edition' in senso ascendente
    // Aggiungere $data come ultimo parametr per ordinare sulla chiave comune
    array_multisort($data, SORT_ASC, $id, SORT_ASC, $giornate);
    
    $query = $db->getQuery(true);
    
    $query->select('*');
    $query->from('#__sm_tornei');
    $query->where('id = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $tornei = $db->loadObjectList();
    
    $squadre_indexes = $tornei[0]->ids_squadre;
    
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_squadre_tornei');
    $query->where('id IN ('.$squadre_indexes.')');
    $db->setQuery((string)$query);
    $squadre = $db->loadObjectList();
    
    $numSquadre = count($squadre);

    if ($squadre) {
        foreach ($squadre as $squadra) {
            $teams[$squadra->id] = $squadra->nome;
        }
    }

    $i = 1;
    ?>
<div class="titoloSezioneSancamanager">
    INSERIMENTO RISULTATI
</div>
<form action="<?php echo($url); ?>" method="post" name="form_risultati_campionato" id="risultati-form">
<table id="tabella_incontri" width="600">
    <thead>
    <td width="450"><strong>Incontro</strong></td>
    <td width="150"><strong>Risultato</strong></td>
    </thead>
    <?php
    foreach ($giornate as $giornata) {
        ?>
    <tr>
        <td colspan="2"><div class="titoloGiornataInserimentoIncontro"><i>Giornata <?php echo($i); ?> del <?php echo($giornata->data); ?></i></div></td>
    </tr>
    <?php
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__sm_incontri');
        $query->where('id_giornata = '.$giornata->id);
        
        $db->setQuery((string)$query);
        $incontri = $db->loadObjectList();
        
        $matrice_incontri[$i] = $incontri;
        $j = 1;
        foreach ($incontri as $incontro) {
            $num_incontri[$i] = count($incontri);
            echo('<tr>');
            echo('<td width="450"><div class="titolo_incontro_inserimento">'.$teams[$incontro->id_squadra1].' - '.$teams[$incontro->id_squadra2].'</div></td><td width="150"><input type="text" value="'.$incontro->reti_squadra1.'" size="4" name="reti_squadra1_incontro'.$j.'_giornata'.$i.'" />-<input type="text" value="'.$incontro->reti_squadra2.'" name="reti_squadra2_incontro'.$j.'_giornata'.$i.'" size="4" /></td>');
            echo('</tr>');
            echo('<input type="hidden" name="idincontro'.$j++.'giornata'.$i.'" value="'.$incontro->id.'" />');
        }
        $i++;
    }
    ?>
</table>
    <input type="hidden" name="salvataggio_risultati" value="1" />
    <input type="hidden" name="numero_giornate" value="<?php echo($numero_giornate); ?>" />
    <input type="hidden" name="numero_incontri" value="<?php echo(serialize($num_incontri)); ?>" />
    <input type="submit" value="Salva risultati" />
</form>
<?php    
    
}
else {
    ?>
    <div class="titoloSezioneSancamanager">
        INSERIMENTO RISULTATI
    </div>
    <div>
        Scegli il campionato:
    </div>

    <?php
    
    $user_id = JFactory::getUser()->id;
    
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_tornei AS a');
    $query->join("left", "#__sm_diritti_aggiornamento_campionati AS b ON a.id = b.id_campionato");
    $query->where('id_utente = '.$user_id);

    $db->setQuery((string)$query);
    $tornei = $db->loadObjectList();

    if ($tornei) {
        ?>
    <form action="<?php echo($url); ?>" method="post" name="form_campionato" id="persone-form">
    <select id="torneo_selezionato" name="torneo_selezionato">
        <?php
        foreach ($tornei as $torneo) {
            echo('<option value="'.$torneo->id.'">'.$torneo->descrizione.'</option>');
        }
        ?>
    </select>
        <input type="submit" value="Carica giornate" />
    </form>
    <?php
    }
    else
        echo('Nessun torneo memorizzato in archivio');
}
?>