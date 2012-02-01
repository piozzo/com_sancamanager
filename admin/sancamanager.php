<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_sancamanager')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// require helper file
JLoader::register('SancaManagerHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'sancamanager.php');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('SancaManager');

$controller->registerTask('squadre', 'display');
$controller->registerTask('categorie', 'displayCategorie');
$controller->registerTask('ruoli', 'displayRuoli');
$controller->registerTask('persone', 'displayPersone');
$controller->registerTask('stagionisportive', 'displayStagioniSportive');
$controller->registerTask('tornei', 'displayTornei');
$controller->registerTask('squadreTornei', 'displaySquadreTornei');
$controller->registerTask('giornate', 'displayGiornate');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

?>