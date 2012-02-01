<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
jimport('joomla.filesystem.file');
 
/**
 * HelloWorld Model
 */
class SancaManagerModelPersone extends JModelAdmin
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
	public function getTable($type = 'Persone', $prefix = 'SancaManagerTable', $config = array()) 
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
		$form = $this->loadForm('com_sancamanager.persone', 'persone', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_sancamanager.edit.persone.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
        
        public function save($data) {
            
            $cartella_upload = JPATH_SITE.DS.'components'.DS.'com_sancamanager'.DS.'images'.DS.'persone'.DS.'def_imgs'.DS;
            
            $img = JRequest::getVar('def_img', NULL, 'files', 'array');
            
            $tipi_consentiti = array("gif","png","jpeg","jpg");   
    
            // 3) settiamo la dimensione massima del file (1048576 byte = 1Mb)  
            $max_byte = 10000000;  
            
            $form_this = $this->getForm();
            
            //$img = $form_this->getField('img_def');

            // se il form è stato inviato  
               // verifichiamo che l'utente abbia selezionato un file
            $data_in_form		= JRequest::getVar('jform', array(), 'post', 'array');
            $files_in_form = JRequest::getVar('jform', array(), 'files', 'array');
            $f_2 = fopen('file_file.txt', 'w+');
//               if(trim($files_in_form["name"]['def_img']) == '')  
//                  {  
//                  fprintf($f_2,'Non hai selezionato nessun file!');
//                  }  
//
//               // verifichiamo che il file è stato caricato  
//               else if(!is_uploaded_file($files_in_form["tmp_name"]['def_img']) or $files_in_form["error"]['def_img']>0)  
//                  {  
//                  fprintf($f_2,'Si sono verificati problemi nella procedura di upload!');
//                  }  
//
//               // verifichiamo che il tipo è fra quelli consentiti  
//               else if(!in_array(strtolower(end(explode('.', $files_in_form["name"]['def_img']))),$tipi_consentiti))  
//                  {  
//                  fprintf($f_2,'Il file che si desidera uplodare non è fra i tipi consentiti!');
//                  }  
//
//               // verifichiamo che la dimensione del file non eccede quella massima  
//               else if($files_in_form["size"]['def_img'] > $max_byte)  
//                  {  
//                  fprintf($f_2,'Il file che si desidera uplodare eccede la dimensione massima!');
//                  }  
//
//                // verifichiamo che la cartella di destinazione settata esista  
//                else if(!is_dir($cartella_upload))  
//                    {  
//                    fprintf($f_2,'La cartella in cui si desidera salvare il file non esiste!');
//                    }  
//
//                // verifichiamo che la cartella di destinazione abbia i permessi di scrittura  
//                else if(!is_writable($cartella_upload))  
//                    {  
//                    fprintf($f_2, "La cartella in cui fare l'upload non ha i permessi!");
//                    }  
//               // verifichiamo il successo della procedura di upload nella cartella settata  
//               else if(!move_uploaded_file($files_in_form["tmp_name"]['def_img'], $cartella_upload.$files_in_form["name"]['def_img']))  
//                  {  
//                  fprintf($f_2,'Ops qualcosa è andato storto nella procedura di upload!');
//                  }  
//
//               // altrimenti significa che è andato tutto ok  
//               else  
//                  {  
//                  fprintf($f_2,'Upload eseguito correttamente!');
//                  }              
            
            fprintf($f_2, "%s", print_r($data_in_form, true));
            fprintf($f_2, "%s", print_r($files_in_form, true));
            fprintf($f_2, "%s", print_r($data, true));
            fprintf($f_2, "%s", $cartella_upload);
            fprintf($f_2, $img['tmp_name']);
            //fprintf($f_2, print_r($form_this, true));
            fclose($f_2);
            
           // $img = $form_this->getField('def_img', NULL);
            
            //$f->upload($img->tmp_name, $cartella_upload.'prova.jpg');
            if (JFile::exists($cartella_upload.$data->id.'jpg'))
                    JFile::delete ($cartella_upload.$data['id'].'jpg');
            
            JFile::upload($files_in_form['tmp_name']['def_img'], $cartella_upload.$data['id'].'.jpg');
            
            $data['def_img'] = 'images'.DS.'persone'.DS.'def_imgs'.DS.$data['id'].'.jpg';
            
            
            
            if (parent::save($data))
                    return true;
            else
                    return false;
        }
}

?>