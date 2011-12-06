<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class SancaManagerController extends JController
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false) 
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'sancamanager'));
 
		// call parent behavior
		parent::display($cachable);
                
                SancaManagerHelper::addSubmenu('sancamanager');
	}
        
        function displaySquadreSancascianese($cachable = false) 
	{
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'squadresancascianeses'));
 
		// call parent behavior
		parent::display($cachable);
                
                SancaManagerHelper::addSubmenu('squadresancascianese');
	}
        
        function displayCategorie() {
            // set default view if not set
            //JRequest::setVar('view', JRequest::getCmd('view', 'categorie'));
            JRequest::setVar('view', 'categories');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('categorie');
        }
        
        function displayRuoli() {
            JRequest::setVar('view', 'ruolis');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('ruoli');
        }
        
        function displayPersone() {
            JRequest::setVar('view', 'persones');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('persone');
        }
        
        function displayStagioniSportive() {
            JRequest::setVar('view', 'stagionisportives');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('stagionisportive');
        }
        
        function displayTornei() {
            JRequest::setVar('view', 'torneis');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('tornei');
        }
        
        function displaySquadreTornei() {
            JRequest::setVar('view', 'squadretorneis');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('squadretornei');
        }
        
        function displayGiornate() {
            JRequest::setVar('view', 'giornates');

            // call parent behavior
            parent::display();

            SancaManagerHelper::addSubmenu('giornate');
        }
}

?>