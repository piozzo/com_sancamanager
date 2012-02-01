<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class SancaManagerViewSancaManagers extends JView
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
                
                $this->setDocument();
	}
	
	protected function addToolBar() 
	{
                $canDo = SancaManagerHelper::getActions();
		JToolBarHelper::title(JText::_('COM_SANCAMANAGER_MANAGER_SANCAMANAGERS'));
		/*if ($canDo->get('core.create'))
                    JToolBarHelper::addNew('sancamanager.add', 'JTOOLBAR_NEW');
                if ($canDo->get('core.edit'))
                        JToolBarHelper::editList('sancamanager.edit');
                if ($canDo->get('core.delete'))
                    JToolBarHelper::deleteList('', 'sancamanagers.delete');
                
                if ($canDo->get('core.admin')) {
                    JToolBarHelper::divider();
                    JToolBarHelper::preferences('com_sancamanager');
                }
                 * 
                 */
                if (!JFactory::getUser()->authorise('core.manage', 'com_sancamanager')) {
                    JToolBarHelper::preferences('com_sancamanager');
                }
                
	}
        
        protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_SANCAMANAGER_ADMINISTRATION'));
	}
}

?>