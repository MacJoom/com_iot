<?php
declare(strict_types=1);
/**
 * Picowapi
 *
 * @package    Picowapi
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Picowapis\Api\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\ApiController;

/**
 * Adresses Api Endpoint Controller
 */
class PicowapisController extends ApiController
{
	protected $contentType = 'picowapis';
	
	protected $default_view = 'picowapis';
}
