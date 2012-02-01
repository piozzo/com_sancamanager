<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $item->id; ?>
		</td>
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
                <td>
                        <?php echo $item->nome; ?>
                </td>
                <td>
                        <?php echo $item->data; ?>
                </td>
                <td>
                        <?php echo $item->ora; ?>
                </td>
                <td>
                        <?php echo $item->descrizione; ?>
                </td>
                <td>
                        <?php echo $item->id_torneo; ?>
                </td>
	</tr>
<?php endforeach; ?>