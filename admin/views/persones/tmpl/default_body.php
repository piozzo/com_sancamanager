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
                        <?php echo $item->cognome; ?>
                </td>
                <td>
                        <?php echo $item->data_di_nascita; ?>
                </td>
                <td>
                        <?php echo $item->id_ruolo; ?>
                </td>
	</tr>
<?php endforeach; ?>