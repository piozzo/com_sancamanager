<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHTML::stylesheet('stile.css', 'components/com_sancamanager/css/' );

$db =& JFactory::getDbo();
?>
<style>
.titoloSezioneSancamanager {
	font-size: 14px;
	background-color: #093;
	height: 25px;
	line-height: 25px;
	text-align: center;
	color: #FF3;
	font-weight: bold;
	margin-left: 5px;
	margin-top: 5px;
	margin-bottom: 5px;
	margin-right: 5px;
}

.titoloGiornata {
	font-size: 14px;
	background-color: #093;
	color: #FF3;
}

.squadra1incontroGiornata {
	float: left;
	width: 200px;
	text-align: left;
}

.squadra2incontroGiornata {
	float: left;
	width: 200px;
	text-align: left;
}

.risultatoIncontroGiornata {
	float: right;
	width: 100px;
}

.bloccoGiornataStampaIncontri {
	margin-top: 20px;
	margin-bottom: 20px;
	width: 600px;
}

td.rigaSancascianese {
    background-color: #FFFF00;
}
</style>
<?php
if (JRequest::getVar('trnmnt') > 0) {
    // carica i dati del campionato selezionato
    $id_torneo = JRequest::getVar('trnmnt');
    
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_tornei');
    $query->where('id = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $torneo = $db->loadObjectList();
    
    ?>
<div class="titoloSezioneSancamanager"><?php echo($torneo[0]->descrizione); ?></div>
    <?php
    
    $query = $db->getQuery(true);
    
    $query->select('*');
    $query->from('#__sm_giornate');
    $query->where('id_torneo = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $giornate = $db->loadObjectList();
    ?>
    <div class="bloccoGiornataStampaIncontri">
    <?php
    $i=1;
    $squadre = array();
    if ($giornate) {
        $giornate_array = array();
        $j=0;
//        foreach ($giornate as $giornata) {
//            $giornate_array[$j]['id'] = $giornata->id;
//            $giornate_array[$j]['data'] = substr($giornata->data,6,4).'-'.substr($giornata->data,3,2).'-'.substr($giornata->data,0,2);
//            $j++;
//        }
        
        // Ottiene un array di colonne
        foreach ($giornate as $key => $giornata) {
            $id[$key]  = $giornata->id;
            $data[$key] = substr($giornata->data,6,4).'-'.substr($giornata->data,3,2).'-'.substr($giornata->data,0,2);
            $j++;
        }

        // Ordina 'volume' in senso discendente, 'edition' in senso ascendente
        // Aggiungere $data come ultimo parametr per ordinare sulla chiave comune
        array_multisort($data, SORT_ASC, $id, SORT_ASC, $giornate);
        
        foreach ($giornate as $giornata) {
            $id_giornata = $giornata->id;

            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__sm_incontri');
            $query->where('id_giornata = '.$id_giornata);
            $query->order('id ASC');

            $db->setQuery((string)$query);
            $incontri = $db->loadObjectList();

            ?>
            <div class="titoloGiornata"><?php echo('<strong>GIORNATA '.($i++).'</strong> del '.$giornata->data); ?></div>
            <?php

            $query = $db->getQuery(true);
            $query->select('*');
            $query->from('#__sm_squadre_tornei');
            $query->where('id IN ('.$torneo[0]->ids_squadre.')');
            $db->setQuery($query);
            $squadre = $db->loadObjectList();
            
            if ($squadre) {
                foreach ($squadre as $squadra) {
                    $teams[$squadra->id] = $squadra->nome;
                }
            }
            
            if ($incontri) {
                foreach ($incontri as $incontro) {

                ?>
                    <div class="incontroGiornata">
                        <div class="squadra1incontroGiornata"><?php echo($teams[$incontro->id_squadra1]); ?></div>
                        <div class="squadra2incontroGiornata"><?php echo($teams[$incontro->id_squadra2]); ?></div>
                    </div>
                    <div class="risultatoIncontroGiornata"><?php echo($incontro->reti_squadra1." - ".$incontro->reti_squadra2); ?></div>
                    <div style="clear:both"></div>
        <?php
                }
            }
            ?>
                    <div style="clear:both">&nbsp;</div>
                    <?php
        }
    }
    ?>
                    <h2>CLASSIFICA</h2>
                    <?php
    stampa_classifica($id_torneo);
    ?>
    </div>
    <div style="clear:both">&nbsp;</div>
<?php
}
else {
    $query = $db->getQuery(true);
    $query->select('a.id AS id_torneo, c.descrizione AS nome_categoria_sportiva, d.url_foto AS url_foto');
    $query->from('#__sm_tornei AS a');
    $query->join('left', '#__sm_stagioni_sportive AS b ON a.id_stagione_sportiva = b.id');
    $query->join('left', '#__sm_cat_squadre AS c ON a.id_categoria_sportiva = c.id');
    $query->join('left', '#__sm_squadre AS d ON d.id_stagione = a.id_stagione_sportiva AND d.id_categoria_sportiva = a.id_categoria_sportiva');
    $query->where('b.stagione_corrente = 1');

    $db->setQuery((string)$query);
    $categorie = $db->loadObjectList();
?>
<div class="titoloSezioneSancamanager">SELEZIONA LA CATEGORIA SPORTIVA</div>
<table width="700" border="0" id="tabellaCategorie">
<?php
        $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $count = 0;
        foreach ($categorie as $single_cat) {

                if ($count == 0)
                        echo('<tr>');

                echo('<td height="50" valign="top">');
                echo('<div class="linkCategoriaSportivaSquadre" align="center">');

                if ($single_cat->url_foto == '')
                        echo('<div class="immagineSquadra"><a href="'.$url.'&trnmnt='.$single_cat->id_torneo.'"><img src="components/com_sancamanager/images/no-foto.jpg" width="200" /></a></div>');
                else
                        echo('<div class="immagineSquadra"><a href="'.$url.'&trnmnt='.$single_cat->id_torneo.'"><img src="'.$single_cat->url_foto.'" width="200"/></a></div>');

                echo('<div class="titoloCategoriaSportiva"><a href="'.$url.'&trnmnt='.$single_cat->id_torneo.'">'.$single_cat->nome_categoria_sportiva.'</a></div>');
                echo('</div>');
                echo('</td>');

                if ($count == 2) {
                        echo('</tr>');
                        $count = -1;
                }

                $count++;
        }

        if ($count == 1)
                echo('<td>&nbsp;</td><td>&nbsp;</td></tr>');
        else if ($count == 2)
                echo('<td>&nbsp;</td></tr>');
?>
</table>
<?php
}

function get_classifica($id_torneo) {
    $db = JFactory::getDbo();

    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_tornei');
    $query->where('id = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $torneo = $db->loadObjectList();
    
    $squadre = explode(',', $torneo[0]->ids_squadre);
        
    foreach ($squadre as $index_squadra) {
        $classifica[$index_squadra]['partiteGiocate'] = 0;
        $classifica[$index_squadra]['partiteVinte'] = 0;
        $classifica[$index_squadra]['partitePareggiate'] = 0;
        $classifica[$index_squadra]['partitePerse'] = 0;
        $classifica[$index_squadra]['partiteVinteCasa'] = 0;
        $classifica[$index_squadra]['partitePareggiateCasa'] = 0;
        $classifica[$index_squadra]['partitePerseCasa'] = 0;
        $classifica[$index_squadra]['partiteVinteFuori'] = 0;
        $classifica[$index_squadra]['partitePareggiateFuori'] = 0;
        $classifica[$index_squadra]['partitePerseFuori'] = 0;
        $classifica[$index_squadra]['retiFatte'] = 0;
        $classifica[$index_squadra]['retiSubite'] = 0;
        $classifica[$index_squadra]['punti'] = 0;

    }

    $puntiVittoria = 3;
    $puntiPareggio = 1;
    $puntiSconfitta = 0;
    
    $query = $db->getQuery(true);
    
    $query->select('*');
    $query->from('#__sm_giornate');
    $query->where('id_torneo = '.$id_torneo);
    
    $db->setQuery((string)$query);
    $giornate = $db->loadObjectList();

    foreach ($giornate as $giornata) {
        
        $id_giornata = $giornata->id;

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__sm_incontri');
        $query->where('id_giornata = '.$id_giornata);
        $query->order('id ASC');

        $db->setQuery((string)$query);
        $incontri = $db->loadObjectList();
        
        foreach ($incontri as $incontro) {
            if ($incontro->reti_squadra1 == '' || $incontro->reti_squadra2 == '')
                    continue;
            if ($incontro->reti_squadra1 > $incontro->reti_squadra2) {
                    // squadra 1
                    $classifica[$incontro->id_squadra1]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra1]['partiteVinte']++;
                    $classifica[$incontro->id_squadra1]['partiteVinteCasa']++;
                    $classifica[$incontro->id_squadra1]['retiFatte'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra1]['retiSubite'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra1]['punti'] += $puntiVittoria;

                    // squadra 2
                    $classifica[$incontro->id_squadra2]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra2]['partitePerse']++;
                    $classifica[$incontro->id_squadra2]['partitePerseFuori']++;
                    $classifica[$incontro->id_squadra2]['retiFatte'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra2]['retiSubite'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra2]['punti'] += $puntiSconfitta;
            }
            else if ($incontro->reti_squadra1 < $incontro->reti_squadra2) {
                    // squadra 1
                    $classifica[$incontro->id_squadra1]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra1]['partitePerse']++;
                    $classifica[$incontro->id_squadra1]['partitePerseCasa']++;
                    $classifica[$incontro->id_squadra1]['retiFatte'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra1]['retiSubite'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra1]['punti'] += $puntiSconfitta;

                    // squadra 2
                    $classifica[$incontro->id_squadra2]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra2]['partiteVinte']++;
                    $classifica[$incontro->id_squadra2]['partiteVinteFuori']++;
                    $classifica[$incontro->id_squadra2]['retiFatte'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra2]['retiSubite'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra2]['punti'] += $puntiVittoria;
            }
            else {
                    // squadra 1
                    $classifica[$incontro->id_squadra1]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra1]['partitePareggiate']++;
                    $classifica[$incontro->id_squadra1]['partitePareggiateCasa']++;
                    $classifica[$incontro->id_squadra1]['retiFatte'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra1]['retiSubite'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra1]['punti'] += $puntiPareggio;

                    // squadra 2
                    $classifica[$incontro->id_squadra2]['partiteGiocate']++;
                    $classifica[$incontro->id_squadra2]['partitePareggiate']++;
                    $classifica[$incontro->id_squadra2]['partitePareggiateFuori']++;
                    $classifica[$incontro->id_squadra2]['retiFatte'] += $incontro->reti_squadra2;
                    $classifica[$incontro->id_squadra2]['retiSubite'] += $incontro->reti_squadra1;
                    $classifica[$incontro->id_squadra2]['punti'] += $puntiPareggio;
            }
        }
    }
    return $classifica; 
}
    
function stampa_classifica($id_torneo) {
    
    $classifica = get_classifica($id_torneo);
    
    $db = JFactory::getDbo();

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
    
        ?>
        <div class="classifica">
		<table width="600" border="0" cellspacing="0" class="tab_classifica">
      <tr>
        <th bgcolor="#009933" scope="col">SQUADRA</th>
        <th bgcolor="#009933" scope="col">PUNTI</th>
        <th bgcolor="#009933" scope="col">G</th>
        <th bgcolor="#009933" scope="col">V</th>
        <th bgcolor="#009933" scope="col">P</th>
        <th bgcolor="#009933" scope="col">S</th>
        <th bgcolor="#009933" scope="col">VC</th>
        <th bgcolor="#009933" scope="col">PC</th>
        <th bgcolor="#009933" scope="col">SC</th>
        <th bgcolor="#009933" scope="col">VF</th>
        <th bgcolor="#009933" scope="col">PF</th>
        <th bgcolor="#009933" scope="col">SF</th>
        <th bgcolor="#009933" scope="col">RF</th>
        <th bgcolor="#009933" scope="col">RS</th>
      </tr>
	 <?php
	 
	 // ordiniamo adesso le squadre per punteggio
	 for ($i=0; $i<$numSquadre; $i++) {
	 	$punti[$squadre[$i]->id] = $classifica[$squadre[$i]->id]['punti'];
	 }
	 
	 arsort($punti);
	// stampiamo adesso la classifica (non ordinata)
	
	foreach ($punti as $idSquadra => $punti) {
		?>
      <tr>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="left" class="nomeSquadra"><?php echo($teams[$idSquadra]); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="puntiSquadra"><?php echo($classifica[$idSquadra]['punti']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partiteGiocate"><?php echo($classifica[$idSquadra]['partiteGiocate']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partiteVinte"><?php echo($classifica[$idSquadra]['partiteVinte']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePareggiate"><?php echo($classifica[$idSquadra]['partitePareggiate']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePerse"><?php echo($classifica[$idSquadra]['partitePerse']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partiteVinteC"><?php echo($classifica[$idSquadra]['partiteVinteCasa']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePareggiateC"><?php echo($classifica[$idSquadra]['partitePareggiateCasa']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePerseC"><?php echo($classifica[$idSquadra]['partitePerseCasa']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partiteVinteF"><?php echo($classifica[$idSquadra]['partiteVinteFuori']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePareggiateF"><?php echo($classifica[$idSquadra]['partitePareggiateFuori']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="partitePerseF"><?php echo($classifica[$idSquadra]['partitePerseFuori']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="retiFatte"><?php echo($classifica[$idSquadra]['retiFatte']); ?></div></td>
        <td <?php if (substr_count(strtolower($teams[$idSquadra]),"sancascianese a.s.d.") == 1) echo('class="rigaSancascianese"'); ?>><div align="center" class="retiSubite"><?php echo($classifica[$idSquadra]['retiSubite']); ?></div></td>
      </tr>
   
		<?php
	}
	?>
	</table>
</div>
	<?php
    }
?>