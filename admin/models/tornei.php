<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * HelloWorld Model
 */
class SancaManagerModelTornei extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Tornei', $prefix = 'SancaManagerTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_sancamanager.tornei', 'tornei', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_sancamanager.edit.tornei.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
                
		return $data;
	}
        
        public function save($data) {
            
            
            
            $data_new = array();
            $data_new['id'] = $data['id'];
            
            $data_new['descrizione'] =  (array_key_exists('descrizione', $data)? $data['descrizione'] : 0);
            $data_new['id_categoria_sportiva'] =  (array_key_exists('id_categoria_sportiva', $data)? $data['id_categoria_sportiva'] : 0);
            $data_new['id_stagione_sportiva'] =  (array_key_exists('id_stagione_sportiva', $data)? $data['id_stagione_sportiva'] : 0);
            
            if (array_key_exists('ids_squadre', $data)) {
                sort($data['ids_squadre'], SORT_NUMERIC);
                $data_new['ids_squadre'] = implode(',', $data['ids_squadre']);
            }
            else
                $data_new['ids_squadre'] = '';
            
            $file_w = fopen('f_test.txt', 'w+');
            
            fwrite($file_w, print_r($data, TRUE));
            fwrite($file_w, print_r($data_new, true));
            fwrite($file_w, ' - '.implode(',', $data_new));
            fclose($file_w);
            
            if (parent::save($data_new))
                    return true;
            else
                    return false;
        }
}

?>