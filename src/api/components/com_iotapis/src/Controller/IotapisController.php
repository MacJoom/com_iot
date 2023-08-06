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

namespace ITC\Component\Iotapis\Api\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\Controller\ApiController;
use Joomla\String\Inflector;
use Tobscure\JsonApi\Exception\InvalidParameterException;

/**
 * Adresses Api Endpoint Controller
 */
class IotapisController extends ApiController
{
	protected $contentType = 'iotapis';

	protected $default_view = 'iotapis';

    protected function save($recordKey = null)
    {
        $model = $this->getModel(Inflector::singularize($this->contentType));

        if (!$model) {
            throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_MODEL_CREATE'));
        }

        try {
            $table = $model->getTable();
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $key        = $table->getKeyName();
        $data       = $this->input->get('data', json_decode($this->input->json->getRaw(), true), 'array');

        $item = $model->getItemByFieldname('name', $data['name']);

        if ($item) {
            $recordKey = $item->$key;
            if ($recordKey && $table->load($recordKey)) {
                $fields = $table->getFields();

                foreach ($fields as $field) {
                    if (array_key_exists($field->Field, $data)) {
                        continue;
                    }

                    $data[$field->Field] = $table->{$field->Field};
                }
            }
        } else {
            return parent::save($recordKey);
        }

        $checkin    = property_exists($table, $table->getColumnAlias('checked_out'));
        $data[$key] = $recordKey;

        $data = $this->preprocessSaveData($data);

        // @todo: Not the cleanest thing ever but it works...
        Form::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/forms');

        // Needs to be set because com_fields needs the data in jform to determine the assigned catid
        $this->input->set('jform', $data);

        // Validate the posted data.
        $form = $model->getForm($data, false);

        if (!$form) {
            throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_FORM_CREATE'));
        }

        // Test whether the data is valid.
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false) {
            $errors   = $model->getErrors();
            $messages = [];

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = \count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof \Exception) {
                    $messages[] = "{$errors[$i]->getMessage()}";
                } else {
                    $messages[] = "{$errors[$i]}";
                }
            }

            throw new InvalidParameterException(implode("\n", $messages));
        }

        if (!isset($validData['tags'])) {
            $validData['tags'] = [];
        }

        // Attempt to save the data.
        if (!$model->save($validData)) {
            throw new Exception\Save(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
        }

        // Save succeeded, so check-in the record.
        if ($checkin && $model->checkin($recordKey) === false) {
            throw new Exception\CheckinCheckout(Text::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
        }

        return $recordKey;
    }

}
