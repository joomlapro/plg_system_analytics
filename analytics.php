<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.Analytics
 *
 * @copyright   Copyright (C) 2013 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('JPATH_BASE') or die;

/**
 * Joomla Analytics plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Analytics
 * @since       3.1
 */
class PlgSystemAnalytics extends JPlugin
{
	/**
	 * Method to catch the onAfterDispatch event.
	 *
	 * @return  boolean  True on success
	 *
	 * @since   3.1
	 */
	public function onAfterDispatch()
	{
		// Check that we are in the site application.
		if (JFactory::getApplication()->isAdmin())
		{
			return true;
		}

		// Get the document object.
		$doc = JFactory::getDocument();

		// Get the base url.
		$base = JUri::getInstance()->toString(array('host'));

		// Build the script.
		$script = array();
		$script[] = '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
		$script[] = '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
		$script[] = 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
		$script[] = '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';

		$script[] = 'ga(\'create\', \'' . $this->params->get('code', 'UA-XXXXXXXX-X') . '\', \'' . $this->params->get('domain', $base) . '\');';
		$script[] = 'ga(\'send\', \'pageview\');';

		// Add the script to the document head.
		$doc->addScriptDeclaration(implode("\n", $script));

		return true;
	}
}
