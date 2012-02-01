<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$db = JFactory::getDbo();
$query_id_cat = $db->getQuery(true);
$query_id_stagione = $db->getQuery(true);

$query_id_cat->select('*');
$query_id_cat->from('#__sm_cat_squadre');
//        
$query_id_stagione->select('*');
$query_id_stagione->from('#__sm_stagioni_sportive');
//        
$db->setQuery((string)$query_id_cat);
$id_cat = $db->loadObjectList();
       
$db->setQuery((string)$query_id_stagione);
$id_stag = $db->loadObjectList();

foreach ($id_cat as $id_categoria) {
    $cat[$id_categoria->id] = $id_categoria->descrizione;
}

foreach ($id_stag as $id_stagione) {
    $stag[$id_stagione->id] = $id_stagione->descrizione;
}

?>
<?php foreach($this->items as $i => $item):
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
        <td>
        	<?php 
                echo $cat[$item->id_categoria_sportiva];
                ?>
        </td>
        <td>
        	<?php echo $stag[$item->id_stagione];
                ?>
        </td>
        <td>
        	<?php echo $item->url_foto; ?>
        </td>
        <td>
                <?php echo $item->descrizione; ?>
        </td>
	</tr>
<?php endforeach; ?>