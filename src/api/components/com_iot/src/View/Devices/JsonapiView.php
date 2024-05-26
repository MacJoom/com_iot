<?php
declare(strict_types=1);
/**
 * Iot
 *
 * @package    Iot
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Iot\Api\View\Devices;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;

/**
 * Iot Api Endpoint JsonApi View
 */
class JsonapiView extends BaseApiView
{
	/**
	 * @var string[] $fieldsToRenderItem
	 */
	protected $fieldsToRenderItem = [
		'id',
		'name',
        'ipaddress',
		'alias',
        'iotdata',
        'catid',
		'category_title',
		'language_title',
		'published',
		'publish_up',
		'publish_down',
		'access',
		'ordering',
	];

	/**
	 * @var string[] $fieldsToRenderList
	 */
	protected $fieldsToRenderList = [
		'id',
		'name',
        'ipaddress',
		'alias',
        'iotdata',
        'catid',
		'category_title',
		'checked_out',
		'checked_out_time',
		'published',
		'access',
		'ordering',
		'language_title',
		'publish_up',
		'publish_down',
	];
}
