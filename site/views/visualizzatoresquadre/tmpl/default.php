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

.body_squadra {
    background-image:url('components/com_sancamanager/images/sfondo_squadre.jpg');
    background-position: center;
    background-repeat: no-repeat;
    height: 950px;
}

.elencoPortieri {
    position: relative;
    top: 50px;
}

.elencoDifensori {
    position: relative;
    top: 50px;
}

.elencoCentrocampisti {
    position: relative;
    top: 100px;
}

.elencoAttaccanti {
    position: relative;
    top: 320px;
}

.titoloPortieri {
    position: relative;
    top: 50px;
}

.titoloDifensori {
    position: relative;
    top: 70px;
}

.titoloCentrocampisti {
    position: relative;
    top: 100px;
}

.titoloAttaccanti {
    position: relative;
    top: 300px;
}
</style>
<?php

if (JRequest::getVar('team') > 0) {
    // carica i dati delle persone della categoria selezionata
    $id = JRequest::getVar('team');
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_squadre');
    $query->where('id = '.$id);
    
    $db->setQuery((string)$query);
    $team = $db->loadObjectList();
    
    $team_people = explode(',', $team[0]->ids_persone);
    
    ?>
<div class="titoloSezioneSancamanager"><?php echo($team[0]->descrizione); ?></div>
<div class="body_squadra">
<?php
    // ALLENATORE
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND b.descrizione LIKE \'Allenatore%\'');
    
    $db->setQuery((string)$query);
    $allenatori = $db->loadObjectList();

    if (count($allenatori) > 0)
    {
        ?>
        <div>
            <h3>ALLENATORI</h3>
        </div>
        <?php
    
    
        foreach ($allenatori as $allenatore) {
            echo('<div>'.$allenatore->nome.' '.$allenatore->cognome.'</div>');
        }
    }
    
    // PORTIERI
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND b.descrizione LIKE \'Portiere%\'');
    
    $db->setQuery((string)$query);
    $portieri = $db->loadObjectList();
    
    if (count($portieri) > 0)
    {
        ?>
        <div class="titoloPortieri">
            <h3>PORTIERI</h3>
        </div>
    <div style="clear: both"></div>
    <div class="elencoPortieri">
        <table width="700" border="0" id="tabellaCategorie">
        <?php
    
    
        $count = 0;
    
        foreach ($portieri as $portiere) {
            
            if ($count == 0)
                echo('<tr>');

            echo('<td height="50" valign="top">');
            echo('<div align="center">');

            echo('<div><a href="#">'.$portiere->nome.' '.$portiere->cognome.'</a></div>');

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
        </div>
    <div style="clear: both"></div>
        <?php
    }   

    // DIFENSORI
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND b.descrizione LIKE \'Difensore%\'');
    
    $db->setQuery((string)$query);
    $difensori = $db->loadObjectList();
    
    if (count($difensori) > 0)
    {
        ?>
        <div class="titoloDifensori">
            <h3>DIFENSORI</h3>
        </div>
    <div style="clear: both"></div>
    <div class="elencoDifensori">
        <table width="700" border="0" id="tabellaCategorie">
        <?php
    
    
        $count = 0;
    
        foreach ($difensori as $difensore) {
            
            if ($count == 0)
                echo('<tr>');

            echo('<td height="50" valign="top">');
            echo('<div align="center">');

            echo('<div><a href="#">'.$difensore->nome.' '.$difensore->cognome.'</a></div>');

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
    </div>
    <div style="clear: both"></div>
    <?php
    }
    
    // CENTROCAMPISTI
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND b.descrizione LIKE \'Centrocampista%\'');
    
    $db->setQuery((string)$query);
    $centrocampisti = $db->loadObjectList();
    
    if (count($centrocampisti) > 0)
    {
        ?>
        <div class="titoloCentrocampisti">
            <h3>CENTROCAMPISTI</h3>
        </div>
    <div style="clear: both"></div>
    <div class="elencoCentrocampisti">
        <table width="700" border="0" id="tabellaCategorie">
        <?php
         $count = 0;
    
        foreach ($centrocampisti as $centrocampista) {
            
            if ($count == 0)
                echo('<tr>');

            echo('<td height="50" valign="top">');
            echo('<div align="center">');

            echo('<div><a href="#">'.$centrocampista->nome.' '.$centrocampista->cognome.'</a></div>');

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
        </div>
        <div style="clear: both"></div>
    
    <?php
    }
    
    // ATTACCANTI
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND b.descrizione LIKE \'Attaccante%\'');
    
    $db->setQuery((string)$query);
    $attaccanti = $db->loadObjectList();
    
    if (count($attaccanti) > 0)
    {
        ?>
        <div class="titoloAttaccanti">
            <h3>ATTACCANTI</h3>
        </div>
    <div style="clear: both"></div>
    <div class="elencoAttaccanti">
    <table width="700" border="0" id="tabellaCategorie">
        <?php
    $count = 0;
    
        foreach ($attaccanti as $attaccante) {
            
            if ($count == 0)
                echo('<tr>');

            echo('<td height="50" valign="top">');
            echo('<div align="center">');

            echo('<div><a href="#">'.$attaccante->nome.' '.$attaccante->cognome.'</a></div>');

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
</div>
    <div style="clear: both"></div>
</div>
<?php
    }
    
    // TUTTI GLI ALTRI...
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__sm_persone AS a');
    $query->join('left', '#__sm_ruoli AS b ON a.id_ruolo = b.id');
    $query->where('a.id IN ('.rtrim($team[0]->ids_persone,',').') AND (b.descrizione NOT LIKE \'Attaccante%\'
        AND b.descrizione NOT LIKE \'Centrocampista%\' AND b.descrizione NOT LIKE \'Difensore%\'
        AND b.descrizione NOT LIKE \'Portiere%\' AND b.descrizione NOT LIKE \'Allenatore%\')');
    
    $db->setQuery((string)$query);
    $others = $db->loadObjectList();
    
    if (count($others) > 0)
    {
        ?>
        <div>
            <h3>ATLETI, ALLENATORI, ACCOMPAGNATORI, o anche solo AMICI :)</h3>
        </div>
        <?php
    
    
        foreach ($others as $other) {
            echo('<div>'.$other->nome.' '.$other->cognome.'</div>');
        }
    }
    ?>
</div>
<?php
}
else {
    $query = $db->getQuery(true);
    $query->select('b.id AS id_squadra, a.descrizione AS desc_cat_sportiva, b.url_foto AS url_foto');
    $query->from('#__sm_cat_squadre AS a');
    $query->join('left', '#__sm_squadre AS b ON a.id = b.id_categoria_sportiva');
    $query->join('left', '#__sm_stagioni_sportive AS c ON b.id_stagione = c.id');
    $query->where('c.stagione_corrente = 1');

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
                        echo('<div class="immagineSquadra"><a href="'.$url.'&team='.$single_cat->id_squadra.'"><img src="components/com_sancamanager/images/no-foto.jpg" width="200" /></a></div>');
                else
                        echo('<div class="immagineSquadra"><a href="'.$url.'&team='.$single_cat->id_squadra.'"><img src="'.$single_cat->url_foto.'" width="200" /></a></div>');

                echo('<div class="titoloCategoriaSportiva"><a href="'.$url.'&team='.$single_cat->id_squadra.'">'.$single_cat->desc_cat_sportiva.'</a></div>');
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
?>