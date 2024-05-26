<?php
declare(strict_types=1);
/**
 * DeviceController
 *
 * @package    Iot
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Iot\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;

/**
 * Controller for a single device
 *
 * @since  0.1.0
 */
class DeviceController extends FormController
{
	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since  0.1.0
	 */
	public function batch($model = null)
	{
		$this->checkToken();

		$myModel = $model ?? $this->getModel('Device', 'Administrator', array());

		// Preset the redirect
		$this->setRedirect(Route::_('index.php?option=com_iot&view=devicedatalist' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}
}
