<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
//jimport( 'joomla.form.fields.combo' );

//JFormHelper::loadFieldClass('combo');
JFormHelper::loadFieldClass('list');
 
/**
 * SancaManager Form Field class for the SancaManager component
 */
class JFormFieldIdCategoria extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'IdCategoria';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__sm_cat_squadre');
                $query->order('descrizione ASC');
		$db->setQuery((string)$query);
		$stagioni = $db->loadObjectList();
		$options = array();
		if ($stagioni)
		{
			foreach($stagioni as $stagione) 
			{
				$options[] = JHtml::_('select.option', $stagione->id, $stagione->descrizione);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
?>
