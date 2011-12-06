<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
jimport( 'joomla.form.fields.checkboxes' );
JFormHelper::loadFieldClass('checkboxes');
 
/**
 * SancaManager Form Field class for the HelloWorld component
 */
class JFormFieldSquadreTornei extends JFormFieldCheckboxes
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'SquadreTornei';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$db->setQuery('SELECT a.id AS id_squadra, a.nome AS nome FROM `#__sm_squadre_tornei` AS a ORDER BY nome ASC;');
		$squadre = $db->loadObjectList();
		$options = array();
		if ($squadre)
		{
			foreach($squadre as $squadra) 
			{
				$options[] = JHtml::_('select.option', $squadra->id_squadra, $squadra->nome);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
                
                
	}
        
        protected function getInput()
	{
		// Initialize variables.
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="checkboxes '.(string) $this->element['class'].'"' : ' class="checkboxes"';

		// Start the checkbox field output.
		$html[] = '<fieldset id="'.$this->id.'"'.$class.'>';

		// Get the field options.
		$options = $this->getOptions();

		// Build the checkbox field output.
		$html[] = '<ul>';
                
                //$file_tmp = fopen('f_tmp.txt', 'w+');
                $this->value = explode(',',$this->value);
                
		foreach ($options as $i => $option) {
                        //fwrite($file_tmp, print_r($option, TRUE).  chr(13));
                        $res = in_array((string)$option->value,(array)$this->value);
                        $res_string = ($res ? 'TRUE' : 'FALSE');
                        //fwrite($file_tmp, '#### '.(string)$option->value.' - '.$this->value.' response: '.$res_string.'####');
			// Initialize some option attributes.
			$checked	= (in_array((string)$option->value,(array)$this->value) ? ' checked="checked"' : '');
			$class		= !empty($option->class) ? ' class="'.$option->class.'"' : '';
			$disabled	= !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick	= !empty($option->onclick) ? ' onclick="'.$option->onclick.'"' : '';

			$html[] = '<li>';
			$html[] = '<input type="checkbox" id="'.$this->id.$i.'" name="'.$this->name.'"' .
					' value="'.htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8').'"'
					.$checked.$class.$onclick.$disabled.'/>';

			$html[] = '<label for="'.$this->id.$i.'"'.$class.'>'.JText::_($option->text).'</label>';
			$html[] = '</li>';
		}
                //fclose($file_tmp);
		$html[] = '</ul>';

		// End the checkbox field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
}
?>
