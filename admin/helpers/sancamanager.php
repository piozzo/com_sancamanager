<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * HelloWorld component helper.
 */
abstract class SancaManagerHelper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_STAGIONI_SPORTIVE'), 'index.php?option=com_sancamanager&view=stagionisportives&task=stagionisportive', $submenu == 'stagionisportive' || $submenu == '');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_SQUADRE'), 'index.php?option=com_sancamanager&view=squadresancascianeses&task=squadre', $submenu == 'squadre');
		JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_CATEGORIE'), 'index.php?option=com_sancamanager&view=categories&task=categorie', $submenu == 'categorie');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_RUOLI'), 'index.php?option=com_sancamanager&view=ruolis&task=ruoli', $submenu == 'ruoli');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_PERSONE'), 'index.php?option=com_sancamanager&view=persones&task=persone', $submenu == 'persone');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_TORNEI'), 'index.php?option=com_sancamanager&view=torneis&task=tornei', $submenu == 'tornei');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_SQUADRE_TORNEI'), 'index.php?option=com_sancamanager&view=squadretorneis&task=squadretornei', $submenu == 'squadretornei');
                JSubMenuHelper::addEntry(JText::_('COM_SANCAMANAGER_SUBMENU_GIORNATE'), 'index.php?option=com_sancamanager&view=giornates&task=giornate', $submenu == 'giornate');
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-sancamanager {background-image: url(../media/com_sancamanager/images/sancamanager-48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_SANCAMANAGER_ADMINISTRATION_CATEGORIE'));
		}
	}
        
        /**
	 * Get the actions
	 */
	public static function getActions($messageId = 0)
	{	
		jimport('joomla.access.access');
		$user	= JFactory::getUser();
		$result	= new JObject;
 
		if (empty($messageId)) {
			$assetName = 'com_sancamanager';
		}
		else {
			$assetName = 'com_sancamanager.message.'.(int) $messageId;
		}
 
		$actions = JAccess::getActions('com_sancamanager', 'component');
 
		foreach ($actions as $action) {
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}
 
		return $result;
        }
}