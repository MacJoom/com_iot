<?php
/**
 * Web Services - Iotapi
 *
 * @package    Iotapi
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       Martin KOPP "MacJoom"
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\ApiRouter;
use Joomla\Router\Route;

/**
 * Web Services adapter for com_iotapis.
 *
 * @since  4.0.0
 */
class PlgWebservicesIot extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Registers com_iotapis's API's routes in the application
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function onBeforeApiRoute(&$router)
	{
		$router->createCRUDRoutes(
			'v1/iot/devices',
			'iot',
			['component' => 'com_iot']
		);

		$router->createCRUDRoutes(
			'v1/iot/categories',
			'categories',
			['component' => 'com_categories', 'extension' => 'com_iot']
		);

		$this->createFieldsRoutes($router);

		$this->createContentHistoryRoutes($router);
	}

	/**
	 * Create fields routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createFieldsRoutes(&$router)
	{
		$router->createCRUDRoutes(
			'v1/fields/iot/devices',
			'fields',
			['component' => 'com_fields', 'context' => 'com_iot.devices']
		);

		$router->createCRUDRoutes(
			'v1/fields/iot/categories',
			'fields',
			['component' => 'com_fields', 'context' => 'com_iot.categories']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/iot/devices',
			'groups',
			['component' => 'com_fields', 'context' => 'com_iot.devices']
		);

		$router->createCRUDRoutes(
			'v1/fields/groups/iot/categories',
			'groups',
			['component' => 'com_fields', 'context' => 'com_iot.categories']
		);
	}

	/**
	 * Create contenthistory routes
	 *
	 * @param   ApiRouter  &$router  The API Routing object
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	private function createContentHistoryRoutes(&$router)
	{
		$defaults    = [
			'component'  => 'com_contenthistory',
			'type_alias' => 'com_iotapis.iotapi',
			'type_id'    => 1,
		];
		$getDefaults = array_merge(['public' => false], $defaults);

		$routes = [
			new Route(['GET'], 'v1/iotapis/devices/:id/contenthistory', 'history.displayList', ['id' => '(\d+)'], $getDefaults),
			new Route(['PATCH'], 'v1/iotapis/devices/:id/contenthistory/keep', 'history.keep', ['id' => '(\d+)'], $defaults),
			new Route(['DELETE'], 'v1/iotapis/devices/:id/contenthistory', 'history.delete', ['id' => '(\d+)'], $defaults),
		];

		$router->addRoutes($routes);
	}
}
