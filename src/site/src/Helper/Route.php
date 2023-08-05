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

namespace ITC\Component\Iotapis\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\CategoryNode;
use Joomla\CMS\Language\Multilanguage;

/**
 * Iotapis Component Route Helper
 *
 * @static
 * @package     Joomla.Site
 * @subpackage  com_iotapis
 * @since       1.5
 */
abstract class Route
{
	/**
	 * Get the URL route for a iotapis from a iotapi ID, iotapis category ID and language
	 *
	 * @param   integer  $id        The id of the iotapis
	 * @param   integer  $catid     The id of the iotapis's category
	 * @param   mixed    $language  The id of the language being used.
	 *
	 * @return  string  The link to the iotapis
	 *
	 * @since   1.5
	 */
	public static function getIotapisRoute($id, $catid, $language = 0)
	{
		// Create the link
		$link = 'index.php?option=com_iotapis&view=iotapi&id=' . $id;

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
	 * Get the URL route for a iotapis category from a iotapis category ID and language
	 *
	 * @param   mixed  $catid     The id of the iotapis's category either an integer id or an instance of CategoryNode
	 * @param   mixed  $language  The id of the language being used.
	 *
	 * @return  string  The link to the iotapis
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
			$link = 'index.php?option=com_iotapis&view=category&id=' . $id;

			if ($language && $language !== '*' && Multilanguage::isEnabled())
			{
				$link .= '&lang=' . $language;
			}
		}

		return $link;
	}
}
