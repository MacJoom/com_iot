<?php
declare(strict_types=1);
/**
 * DevicedatalistModel
 *
 * @package    Iot
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Iot\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Utilities\ArrayHelper;

/**
 * Methods supporting a list of device records.
 *
 * @since  0.1.0
 */
class DevicedatalistModel extends ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     \JControllerLegacy
	 * @since  0.1.0
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name', 'a.name',
                'iotdata', 'a.iotdata',
				'created', 'a.created'
			);

		}

		parent::__construct($config);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  \Joomla\Database\QueryInterface
	 *
	 * @since  0.1.0
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDatabase();
		$query = $db->getQuery(true);

		$app = Factory::getApplication();

		// Select the required fields from the table.
		$query->select(
			$db->quoteName(
				explode(
					', ',
					$this->getState(
						'list.select',
						'a.id, a.name, a.iotdata, a.access, a.created'
					)
				)
			)
		);

		$query->from($db->quoteName('#__iot_data', 'a'));

		// Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where($db->quoteName('a.access') . ' = ' . (int) $access);
		}


		// Filter by search in name.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where(
					'(' . $db->quoteName('a.name') . ' LIKE ' . $search . ')'
				);
			}
		}

		$name = $this->getState('filter.name', []);
		if ($name)
		{
			$query->where($db->quoteName('a.name') . ' = "' . $name.'"');
		}
		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.name');
		$orderDirn = $this->state->get('list.direction', 'asc');

		if ($orderCol == 'a.ordering' || $orderCol == 'category_title')
		{
			$orderCol = $db->quoteName('c.title') . ' ' . $orderDirn . ', ' . $db->quoteName('a.ordering');
		}

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since  0.1.0
	 */
	protected function populateState($ordering = 'a.name', $direction = 'asc')
	{
		$app = Factory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$value = $app-> input-> get(' limit', $app-> get(' list_limit', 0), 'uint');
		$this-> setState(' list.limit', $value);
		$value = $app-> input-> get(' limitstart', 0, 'uint');
		$this-> setState(' list.start', $value);
		$search = $this-> getUserStateFromRequest( $this-> context . '. filter.search', 'filter_search');
		$this-> setState(' filter.search', $search);

		$name = $this->getUserStateFromRequest($this->context . '.filter.name', 'filter_name');
		$this->setState('filter.name', $name);

		/* $formSubmitted = $app->input->post->get('form_submitted');
		if ($formSubmitted) {
			$deviceId = $app->input->post->get('name');
			$this->setState('filter.name', $name);
		} */

		// List state information.
		parent::populateState($ordering, $direction);

	}
}
