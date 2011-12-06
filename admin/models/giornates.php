<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * HelloWorldList Model
 */
class SancaManagerModelGiornates extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
            // prendiamo l'id del torneo
            $id_torneo_file = fopen('ID_TORNEO.txt', 'r');
            $id_torneo = fscanf($id_torneo_file,'%u');
            fclose($id_torneo_file);
            
            /*$id_torneo_file = fopen('ID_TORNEO_array.txt', 'w+');
            //fscanf($id_torneo_file,'%u');
            fprintf($id_torneo_file, print_r($id_torneo, true));
            fclose($id_torneo_file);*/
            
            
            
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		$query->from('#__sm_giornate');
                $query->where('id_torneo = '.$id_torneo[0]);
		return $query;
	}
}