<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class SancaManagerViewRuolis extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		
		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}
	
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_SANCAMANAGER_MANAGER_RUOLI'));
		JToolBarHelper::deleteList('', 'ruolis.delete');
		JToolBarHelper::editList('ruoli.edit');
		JToolBarHelper::addNew('ruoli.add');
	}
}

?>