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
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

if ($this->item->params->get('show_name')) {
	if ($this->Params->get('show_iot_name_label')) {
		echo Text::_('COM_IOT_NAME') . $this->item->deviceid;
	} else {
		echo $this->item->deviceid;
	}
}
if ($this->item->params->get('show_ipaddress')) {
    if ($this->Params->get('show_iot_ipaddress_label')) {
        echo Text::_('COM_IOT_IPADDRESS') . $this->item->ipaddress;
    } else {
        echo $this->item->ipaddress;
    }
}

echo $this->item->event->afterDisplayTitle;
echo $this->item->event->beforeDisplayContent;
echo $this->item->event->afterDisplayContent;
