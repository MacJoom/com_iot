<?php
declare(strict_types=1);
/**
 * Device
 *
 * @package    Device
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */

namespace ITC\Component\Iot\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\CategoryNode;
use Joomla\CMS\Language\Multilanguage;

/**
 * Iot Component Route Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_iot
 * @since       1.5
 */
abstract class Route
{
	/**
	 * Get the URL route for a devicedatalist from a device ID, devicedatalist category ID and language
	 *
	 * @param   integer  $id        The id of the devicedatalist
	 * @param   integer  $catid     The id of the devicedatalist's category
	 * @param   mixed    $language  The id of the language being used.
	 *
	 * @return  string  The link to the devicedatalist
	 *
	 * @since   1.5
	 */
	public static function getIotRoute($id, $catid, $language = 0)
	{
		// Create the link
		$link = 'index.php?option=com_iot&view=device&id=' . $id;

		if ($catid > 1)
		{
			$link .= '&catid=' . $catid;
		}

		if ($language && $language !== '*' && Multilanguage::isEnabled())
		{
			$link .= '&lang=' . $language;
		}

		return $link;
	}

	/**
	 * Get the URL route for a devicedatalist category from a devicedatalist category ID and language
	 *
	 * @param   mixed  $catid     The id of the devicedatalist's category either an integer id or an instance of CategoryNode
	 * @param   mixed  $language  The id of the language being used.
	 *
	 * @return  string  The link to the devicedatalist
	 *
	 * @since   1.5
	 */
	public static function getCategoryRoute($catid, $language = 0)
	{
		if ($catid instanceof CategoryNode)
		{
			$id = $catid->id;
		}
		else
		{
			$id = (int) $catid;
		}

		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			// Create the link
			$link = 'index.php?option=com_iot&view=category&id=' . $id;

			if ($language && $language !== '*' && Multilanguage::isEnabled())
			{
				$link .= '&lang=' . $language;
			}
		}

		return $link;
	}
}
