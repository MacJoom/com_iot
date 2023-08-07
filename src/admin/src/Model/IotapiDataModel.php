<?php
declare(strict_types=1);
/**
 * Iotapi
 *
 * @package    Iotapi
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Iotapis\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Object\CMSObject;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * Item Model for a Iotapi.
 *
 * @since  0.1.0
 */
class IotapiDataModel extends AdminModel
{
	/**
	 * The type alias for this content type.
	 *
	 * @var    string
	 * @since  0.1.0
	 */
	public $typeAlias = 'com_iotapis.iotapi';

	/**
	 * The context used for the associations table
	 *
	 * @var    string
	 * @since  0.1.0
	 */
	protected $associationsContext = 'com_iotapis.data';

	/**
	 * Batch copy/move command. If set to false, the batch copy/move command is not supported
	 *
	 * @var  string
	 */

	/**
	 * Method to get the row form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  \JForm|boolean  A \JForm object on success, false on failure
	 *
	 * @since  0.1.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_iotapis.iotapi.data', 'iotapi.data', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since  0.1.0
	 */
	protected function loadFormData()
	{
		$app = Factory::getApplication();

		$data = $this->getItem();

		$this->preprocessData('com_iotapis.iotapi.data', $data);

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed  Object on success, false on failure.
	 *
	 * @since  0.1.0
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		return $item;
	}


    /**
	 * Preprocess the form.
	 *
	 * @param   \JForm  $form   Form object.
	 * @param   object  $data   Data object.
	 * @param   string  $group  Group name.
	 *
	 * @return  void
	 *
	 * @since  0.1.0
	 */
	protected function preprocessForm(\JForm $form, $data, $group = 'content')
	{
		parent::preprocessForm($form, $data, $group);
	}
}
