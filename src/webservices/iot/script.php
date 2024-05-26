<?php
/**
 * @package    Iot
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       Martin KOPP "MacJoom"
 */
use Joomla\CMS\Installer\InstallerScript;
use Joomla\CMS\Installer\InstallerAdapter;

defined('_JEXEC') or die;

/**
 * Iot script file.
 *
 * @package   Iot
 * @since     0.1.0
 */
class PlgWebservicesIotInstallerScript extends InstallerScript
{

    protected $minimumPhp = '7.2.5';
	protected $minimumJoomla = '4.0';
	

	/**
	 * Constructor
	 *
	 * @param  InstallerAdapter $adapter  The object responsible for running this script
	 */
	public function __construct($adapter) {}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($route, $adapter) {}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($route, $adapter) {}

	/**
	 * Called on installation
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install($adapter) {}

	/**
	 * Called on update
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update($adapter) {}

	/**
	 * Called on uninstallation
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 */
	public function uninstall($adapter) {}
}
