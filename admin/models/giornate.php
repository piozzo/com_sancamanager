<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * HelloWorld Model
 */
class SancaManagerModelGiornate extends JModelAdmin
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
	public function getTable($type = 'Giornate', $prefix = 'SancaManagerTable', $config = array()) 
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
		$form = $this->loadForm('com_sancamanager.giornate', 'giornate', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_sancamanager.edit.giornate.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
                
		return $data;
	}
        
        public function save($data) {
          
            $risultato_salvataggio = parent::save($data);
            
            $db = JFactory::getDbo(); 

            // ricaviamoci l'id della giornata
            $f = fopen("nuova_giornata.txt", "r");
            fscanf($f, "%u-%u", $nuova_giornata, $id_giornata);
            fclose($f);
            
            if ($nuova_giornata == 1) {
                $db->setQuery("SHOW TABLE STATUS LIKE 'jos_sm_giornate'");
                $result = $db->loadObjectList();

                if ($result)
                    $id_giornata = $result[0]->Auto_increment-1;
                else {
                    die();
                }
            }
            
            $f_2 = fopen("file_aggeggio.txt", "w+");
            fprintf($f_2, "%u-%u", $id_giornata, $numero_incontri);
  
            $numero_incontri = JRequest::getVar ('num_incontri_giornata'); //(array_key_exists('num_incontri_giornata', $data)? $data['num_incontri_giornata'] : 0);
            
            // eliminiamo tutti gli incontri precedentemente salvati
            $db->setQuery("DELETE FROM `jos_sm_incontri` WHERE id_giornata = ".$id_giornata);
            $result = $db->query();
            
            if ($result)
                fprintf($f_2, 'incontri eliminati! Ci prepariamo ad inserire %u incontri!', JRequest::getVar ('num_incontri_giornata'));
            
            fprintf($f_2, print_r($data, true));
            
            for ($i=1; $i <= $numero_incontri; $i++) {
                $squadra1 = JRequest::getVar('squadra1_incontro'.$i); //$data['squadra1_incontro'.$i];
                $squadra2 = JRequest::getVar('squadra2_incontro'.$i); //$data['squadra2_incontro'.$i];
                
                $reti_squadra1 = JRequest::getVar('reti_squadra1_incontro'.$i); //$data['reti_squadra1_incontro'.$i];
                $reti_squadra2 = JRequest::getVar('reti_squadra2_incontro'.$i); //$data['reti_squadra2_incontro'.$i];
                
                $data_incontro = JRequest::getVar('data_incontro'.$i); //$data['data_incontro'.$i];
                $ora_incontro = JRequest::getVar('ora_incontro'.$i); //$data['ora_incontro'.$i];
                $luogo_incontro = JRequest::getVar('luogo_incontro'.$i); //$data['luogo_incontro'.$i];
                
                $incontro = new stdClass;
                
                $incontro->id = NULL;
                $incontro->id_giornata = $id_giornata;
                $incontro->data = $data_incontro;
                $incontro->ora = $ora_incontro;
                $incontro->luogo = $luogo_incontro;
                $incontro->id_squadra1 = $squadra1;
                $incontro->id_squadra2 = $squadra2;
                if ($reti_squadra1 == '')
                    $incontro->reti_squadra1 = NULL;
                else
                    $incontro->reti_squadra1 = $reti_squadra1;
                if ($reti_squadra2 == '')
                    $incontro->reti_squadra2 = NULL;
                else
                    $incontro->reti_squadra2 = $reti_squadra2;
                
                if (!$db->insertObject('#__sm_incontri', $incontro, 'id')) {
                    echo $db->stderr();
                    fprintf($f_2, "die...");
                    fclose($f_2);
                    return false;
                }
                
                fprintf($f_2, "I was here ^_^");
                
//                $query = "INSERT INTO `jos_sm_incontri` VALUES (null, '".$id_giornata."', '".$data_incontro."', '".$ora_incontro."', '".$luogo_incontro."', ".$squadra1.", ".$squadra2.", ".$reti_squadra1.", ".$reti_squadra2.");";
//                $db->setQuery($query);
//                $result = $db->loadObjectList();
//                fprintf($f_2, '%s', $query);
            }
            
            fclose($f_2);
            
            if ($risultato_salvataggio)
                    return true;
            else
                    return false;
            
           
        }
}

?>