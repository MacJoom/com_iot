<?php
declare(strict_types=1);
/**
 * devicedatalist/default.php
 *
 * @package    Iot
 *
 * @author     Martin KOPP "MacJoom" <martin.kopp@infotech.ch>
 * @copyright  Copyright(c) 2009 - 2021 Martin KOPP "MacJoom". All rights reserved
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://infotech.ch
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

$canChange  = true;
$assoc = Associations::isEnabled();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = true; //$listOrder == 'a.ordering';

if ($saveOrder && !empty($this->items))
{
	$saveOrderingUrl = 'index.php?option=com_iot&task=devicedatalist.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
}
?>
<form action="<?php echo Route::_('index.php?option=com_iot&view=devicedatalist'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<?php if (!empty($this->sidebar)) : ?>
			<div id="j-sidebar-container" class="col-md-2">
				<?php echo $this->sidebar; ?>
			</div>
		<?php endif; ?>
		<div class="<?php if (!empty($this->sidebar)) {echo 'col-md-10'; } else { echo 'col-md-12'; } ?>">
			<div id="j-main-container" class="j-main-container">
				<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-warning">
						<?php echo Text::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>
					<table class="table" id="deviceList">
						<caption id="captionTable" class="sr-only">
							<?php echo Text::_('COM_IOT_TABLE_CAPTION'); ?>, <?php echo Text::_('JGLOBAL_SORTED_BY'); ?>
						</caption>
						<thead>
							<tr>
                                <td style="width:1%" class="text-center">
									<?php echo HTMLHelper::_('grid.checkall'); ?>
                                </td>
                                <th scope="col" class="w-10 d-none d-md-table-cell text-center">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_IOT_TABLE_TABLEHEAD_DATE_CREATED', 'a.created', $listDirn, $listOrder); ?>
                                </th>
								<th scope="col" style="width:1%" class="text-center d-none d-md-table-cell">
									<?php echo HTMLHelper::_('searchtools.sort', 'COM_IOT_TABLE_TABLEHEAD_NAME', 'a.name', $listDirn, $listOrder); ?>
								</th>
								<th scope="col">
									<?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
                                <th scope="col">
									<?php echo Text::_('COM_IOT_FIELD_IOTDATA_LABEL'); ?>
                                </th>
							</tr>
						</thead>
                        <tbody<?php if ($saveOrder) :
							?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="true"<?php
						endif; ?>>
                        <?php
						$n = count($this->items);
						foreach ($this->items as $i => $item) :
							?>
							<tr class="row<?php echo $i % 2; ?>">
                                <td class="text-center">
									<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                                </td>
                                <td class="small d-none d-md-table-cell text-center">
									<?php
									$date = $item->created;
									echo $date > 0 ? HTMLHelper::_('date', $date, Text::_('DATE_FORMAT_LC6')) : '-';
									?>
                                </td>

								<th scope="row" class="has-context">
									<div>
										<?php echo $this->escape($item->name); ?>
									</div>
									<div class="small">
										<?php echo Text::_('JCATEGORY') . ': ' . $this->escape($item->category_title); ?>
									</div>

								</th>
								<td class="d-none d-md-table-cell">
									<?php echo $item->id; ?>
								</td>
                                <td class="d-none d-md-table-cell">
									<?php
                                        $data = str_replace( "\n", '', $item->iotdata);
                                        $data = str_replace( '"memory":', '"memory":"', $data);
									    $data = str_replace( '}','"}', $data);

									    $data = json_decode($data, true);

                                        if (is_array($data)) {
                                            foreach ($data as $key => $value)
                                                {
                                                    echo $key.':'.$value.' ';
                                                }
                                        }
                                    ?>
                                </td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>

					<?php echo $this->pagination->getListFooter(); ?>

					<?php echo HTMLHelper::_(
						'bootstrap.renderModal',
						'collapseModal',
						array(
							'title'  => Text::_('COM_IOT_BATCH_OPTIONS'),
							'footer' => $this->loadTemplate('batch_footer'),
						),
						$this->loadTemplate('batch_body')
					); ?>

				<?php endif; ?>
				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo HTMLHelper::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
