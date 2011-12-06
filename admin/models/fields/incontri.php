<?php
// No direct access to this file
defined('_JEXEC') or die;

jimport( 'joomla.form.formfield' );
jimport( 'joomla.form.fields.text' );
jimport( 'joomla.form.fields.calendar' );
jimport( 'joomla.form.fields.combo' );

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('calendar');
JFormHelper::loadFieldClass('combo');
 
/**
 * SancaManager Form Field class for the HelloWorld component
 */

class JFormFieldIncontri extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Incontri';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
//	protected function getOptions() 
//	{
//		$db = JFactory::getDBO();
//		$query = $db->getQuery(true);
//		$query->select('a.id AS id_stagione, a.descrizione AS descrizione, a.anno AS anno');
//		$query->from('#__sm_stagioni_sportive AS a');
//		$db->setQuery((string)$query);
//		$stagioni = $db->loadObjectList();
//		$options = array();
//		if ($stagioni)
//		{
//			foreach($stagioni as $stagione) 
//			{
//				$options[] = JHtml::_('select.option', $stagione->id_stagione, $stagione->anno.' - '.$stagione->descrizione);
//			}
//		}
//		$options = array_merge(parent::getOptions(), $options);
//		return $options;
//	}
        
        protected function getInput() {
            
            return $this->printNewBlankMatch();
        }
        
        private function printNewBlankMatch() {
            
            $squadra1 = new JFormFieldCombo();
            $squadra1_reti = new JFormFieldText();
            $squadra2 = new JFormFieldCombo();
            $squadra2_reti = new JFormFieldText();
            $dataIncontro = new JFormFieldCalendar();
            
            return $squadra1->getInput().$squadra1_reti->getInput().' - '.$squadra2->getInput().$squadra2_reti->getInput().'<br>'.$dataIncontro->getInput();
        }
}
?>
