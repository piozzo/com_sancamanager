<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * SancaManager Form Field class for the HelloWorld component
 */
class JFormFieldIdStagione extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'IdStagione';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('a.id AS id_stagione, a.descrizione AS descrizione, a.anno AS anno');
		$query->from('#__sm_stagioni_sportive AS a');
		$db->setQuery((string)$query);
		$stagioni = $db->loadObjectList();
		$options = array();
		if ($stagioni)
		{
			foreach($stagioni as $stagione) 
			{
				$options[] = JHtml::_('select.option', $stagione->id_stagione, $stagione->anno.' - '.$stagione->descrizione);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
?>
