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
class IotapiModel extends AdminModel
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
	protected $associationsContext = 'com_iotapis.item';

	/**
	 * Batch copy/move command. If set to false, the batch copy/move command is not supported
	 *
	 * @var  string
	 */
	protected $batch_copymove = 'category_id';

	/**
	 * Allowed batch commands
	 *
	 * @var array
	 */
	protected $batch_commands = array(
		'assetgroup_id' => 'batchAccess',
		'language_id'   => 'batchLanguage',
	);

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
		$form = $this->loadForm('com_iotapis.iotapi', 'iotapi', array('control' => 'jform', 'load_data' => $loadData));

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

		$this->preprocessData('com_iotapis.iotapi', $data);

		return $data;
	}

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   4.3.0
     */
    public function save($data)
    {
        $table = $this->getTable('IotapiData');
        $input = Factory::getApplication()->getInput();
        $fields = $table->getFields();
        $key = $table->getKeyName();
        $recordKey = $data[$key];
        $data[$key] = ''; //make sure we get a new record for data
        foreach ($fields as $field) {
            if (array_key_exists($field->Field, $data)) {
                continue;
            }
            $data[$field->Field] = $table->{$field->Field};
        }
        $table->save($data);
        $data[$key] = $recordKey; //restore key for detail
        return parent::save($data);
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

		// Load associated iotapi items
		$assoc = Associations::isEnabled();

		if ($assoc)
		{
			$item->associations = array();

			if ($item->id != null)
			{
				$associations = Associations::getAssociations('com_iotapis', '#__iotapis_details', 'com_iotapis.item', $item->id, 'id', null);

				foreach ($associations as $tag => $association)
				{
					$item->associations[$tag] = $association->id;
				}
			}
		}

		return $item;
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
    public function getItemByFieldname($field, $value = null)
    {
        if ($value == null)
            return null;

        $table  = $this->getTable();
        $db     = $this->getDatabase();
        $tablename = $table->getTableName();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName($tablename));
        $fields = array_keys($this->getProperties());

        // Check that $field is in the table.
        if (!\in_array($field, $fields)) {
            throw new \UnexpectedValueException(sprintf('Missing field in database: %s &#160; %s.', \get_class($this), $field));
        }

        // Add the search tuple to the query.
        $query->where($db->quoteName($field) . ' = ' . $db->quote($value));

        $db->setQuery($query);

        $row = $db->loadAssoc();

        // Check that we have a result.
        if (empty($row)) {
            $result = false;
        } else {
            // Bind the object with the row and return.
            $result = $table->bind($row);
        }
        if ($result) {
            $properties = $table->getProperties(1);
            $item       = ArrayHelper::toObject($properties, CMSObject::class);

            if (property_exists($item, 'params')) {
                $registry     = new Registry($item->params);
                $item->params = $registry->toArray();
            }

            return $item;

        } else {
            return null;
        }
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
		// Association contact items
		if (Associations::isEnabled())
		{
			$languages = LanguageHelper::getContentLanguages(false, true, null, 'ordering', 'asc');

			if (count($languages) > 1)
			{
				$addform = new \SimpleXMLElement('<form />');
				$fields = $addform->addChild('fields');
				$fields->addAttribute('name', 'associations');
				$fieldset = $fields->addChild('fieldset');
				$fieldset->addAttribute('name', 'item_associations');

				foreach ($languages as $language)
				{
					$field = $fieldset->addChild('field');
					$field->addAttribute('name', $language->lang_code);
					$field->addAttribute('type', 'modal_iotapi');
					$field->addAttribute('language', $language->lang_code);
					$field->addAttribute('label', $language->title);
					$field->addAttribute('translate_label', 'false');
					$field->addAttribute('select', 'true');
					$field->addAttribute('new', 'true');
					$field->addAttribute('edit', 'true');
					$field->addAttribute('clear', 'true');
				}

				$form->load($addform, false);
			}
		}

		parent::preprocessForm($form, $data, $group);
	}
}
