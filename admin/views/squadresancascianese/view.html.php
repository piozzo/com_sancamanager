<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorld View
 */
class SancaManagerViewSquadreSancascianese extends JView
{
	/**
	 * display method of Hello view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
                $script = $this->get('Script');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
                $this->script = $script;
 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
                
                $this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
                $user = JFactory::getUser();
                $userId = $user->id;
		$isNew = ($this->item->id == 0);
                $canDo = SancaManagerHelper::getActions($this->item->id);
		JToolBarHelper::title($isNew ? JText::_('COM_SANCAMANAGER_MANAGER_SANCAMANAGER_NEW') : JText::_('COM_SANCAMANAGER_MANAGER_SANCAMANAGER_EDIT'), 'sancamanager');
                
                /*if ($isNew) {
                    // For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
				JToolBarHelper::apply('sancamanager.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('sancamanager.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('sancamanager.save2new', 'save-new.png', 'save-new_f2.png',
				                       'JTOOLBAR_SAVE_AND_NEW', false);
			}
                        else {
                            if ($canDo->get('core.edit')) {
                                // We can save the new record
				JToolBarHelper::apply('sancamanager.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('sancamanager.save', 'JTOOLBAR_SAVE');
                                
                                // We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($canDo->get('core.create')) 
				{
					JToolBarHelper::custom('sancamanager.save2new', 'save-new.png', 'save-new_f2.png',
					                       'JTOOLBAR_SAVE_AND_NEW', false);
				}
                            }
                            if ($canDo->get('core.create')) {
                                JToolBarHelper::custom('sancamanager.save2copy', 'save-copy.png', 'save-copy_f2.png',
				                       'JTOOLBAR_SAVE_AS_COPY', false);
                            }
                        }
			JToolBarHelper::cancel('sancamanager.cancel', 'JTOOLBAR_CLOSE');
                }*/
                JToolBarHelper::title($isNew ? JText::_('COM_SANCAMANAGER_MANAGER_SQUADRESANCASCIANESE_NEW') : JText::_('COM_SANCAMANAGER_MANAGER_SQUADRESANCASCIANESE_EDIT'));
		JToolBarHelper::save('squadresancascianese.save');
		JToolBarHelper::cancel('squadresancascianese.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
        
        /**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = $this->item->id == 0;
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_SANCAMANAGER_SANCAMANAGER_CREATING')
		                           : JText::_('COM_SANCAMANAGER_SANCAMANAGER_EDITING'));
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_sancamanager"
		                                  . "/views/squadresancascianese/submitbutton.js");
		JText::script('COM_SANCAMANAGER_SANCAMANAGER_ERROR_UNACCEPTABLE');
	}
}