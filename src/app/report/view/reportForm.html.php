<?php
	use n2n\impl\web\dispatch\mag\model\MagForm;
	use n2n\impl\web\ui\view\html\HtmlView;
	use report\bo\Report;
	use report\util\ReportUtils;
	use rocket\si\control\SiIconType;
	
	/**
	 * @var \n2n\web\ui\view\View $view
	 */
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	$formHtml = HtmlView::formHtml($view);
	
	$magForm = $view->getParam('magForm');
	$view->assert($magForm instanceof MagForm);
	$report = $view->getParam('report');
	$view->assert($report instanceof Report);
	
	$reportGenerated = $view->getParam('reportGenerated');
	$reportResults = $view->getParam('reportResults');
	
	$view->useTemplate('\rocket\core\view\template.html',
			array('title' => $view->getL10nText('script_cmd_run_report_title'), 'selectViewToolbar' => true));
?> 
<?php //$html->out($html->getMessageList()) ?>
<?php $formHtml->open($magForm) ?>
	<div class="rocket-entry">
		<div class="rocket-group rocket-simple-group">
			<div class="rocket-structure-content">
				<div class="rocket-read-only rocket-field rocket-item">
					<label><?php $html->text('script_cmd_run_name_label') ?></label>
					<div class="rocket-structure-content">
						<?php $html->escBr($report->getName()) ?>
					</div>
				</div>
				<?php if ($report->hasQueryVariables()): ?>
					<div class="rocket-read-only rocket-field rocket-item">
						<label><?php $html->text('script_cmd_variable_name_label') ?></label>
						<div class="rocket-structure-content">
					   	 	<?php $view->import('\n2n\impl\web\dispatch\mag\view\magForm.html') ?>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<?php if ($reportGenerated): ?>
		<h3><?php $html->text('script_cmd_run_report_results_title') ?></h3>
		<?php if (count($reportResults) === 0): ?>
			<div class="alert alert-info">
				<?php $html->text('no_results_given_txt') ?>
			</div>
		<?php else: ?>
			<table class="table table-hover rocket-table">
				<thead>
					<tr>
						<?php foreach ($reportResults['columnNames'] as $columnName): ?>
							<th><?php $html->out($columnName)?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($reportResults['rows'] as $row): ?>
						<tr>
							<?php foreach ($row as $rowValue): ?>
								<?php if (ReportUtils::containsHtml($rowValue)): ?>
									<td><?php $view->out($rowValue) ?></td>
								<?php else: ?>
									<td><?php $html->out($rowValue) ?></td>
								<?php endif ?>
							<?php endforeach ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
	<?php endif ?>
	<div class="rocket-zone-commands">
		<div class="rocket-main-commands">
			<?php if ($report->hasQueryVariables()): ?>
				<button type="submit" name="command" value="run" class="btn btn-secondary">
					<i class="<?php $html->out(SiIconType::ICON_PLAY_CIRCLE) ?>"></i>
					<span> <?php $html->out($view->getL10nText('script_cmd_run_report_label')) ?></span>
				</button>
			<?php endif ?>
			<button type="submit" name="command" value="csv" class="btn btn-secondary">
				<i class="<?php $html->out(SiIconType::ICON_TABLE) ?>"></i>
				<span> <?php $html->out($view->getL10nText('script_cmd_export_report_label')) ?></span>
			</button>
		</div>
	</div>
<?php $formHtml->close() ?>