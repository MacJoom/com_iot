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
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

echo "<hr>Here you can show a headertext<hr>";

if ($this->item->params->get('show_deviceid')) {
	if ($this->Params->get('show_picowapi_name_label')) {
		echo Text::_('COM_PICOWAPIS_NAME') . $this->item->deviceid;
	} else {
		echo $this->item->deviceid;
	}
}

if ($this->item->params->get('show_ipaddress')) {
    if ($this->Params->get('show_picowapi_ipaddress_label')) {
        echo Text::_('COM_PICOWAPIS_IPADDRESS') . $this->item->ipaddress;
    } else {
        echo $this->item->ipaddress;
    }
}

echo $this->item->event->afterDisplayTitle;
echo $this->item->event->beforeDisplayContent;
echo $this->item->event->afterDisplayContent;
