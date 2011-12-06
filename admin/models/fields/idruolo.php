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
class JFormFieldIdRuolo extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	public $type = 'IdRuolo';
 
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
		$query->from('#__sm_ruoli');
                $query->order('descrizione ASC');
		$db->setQuery((string)$query);
		$ruoli = $db->loadObjectList();
		$options = array();
		if ($ruoli)
		{
			foreach($ruoli as $ruolo) 
			{
				$options[] = JHtml::_('select.option', $ruolo->id, $ruolo->descrizione);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
?>
