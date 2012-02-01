<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * HelloWorld Model
 */
class SancaManagerModelStagioniSportive extends JModelAdmin
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
	public function getTable($type = 'StagioniSportive', $prefix = 'SancaManagerTable', $config = array()) 
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
		$form = $this->loadForm('com_sancamanager.stagionisportive', 'stagionisportive', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_sancamanager.edit.stagionisportive.data', array());
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
            $data_new['stagione_corrente'] =  (array_key_exists('stagione_corrente', $data)? 1 : 0);
            $data_new['ids_persone'] =  (array_key_exists('ids_persone', $data)? $data['ids_persone'] : '');
            $data_new['anno'] =  (array_key_exists('anno', $data)? $data['anno'] : '');
            
            if (parent::save($data_new))
                    return true;
            else
                    return false;
        }
}

?>