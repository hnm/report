<?php
	use n2n\impl\web\ui\view\csv\CsvBuilder;
	use n2n\impl\web\ui\view\csv\CsvView;

	$view = CsvView::view($this);
	$csvBuilder = new CsvBuilder($view);
	$view->assert($csvBuilder instanceof CsvBuilder);
	
	$reportResults = $view->getParam('reportResults');
	$view->assert(is_array($reportResults) || $reportResults === null);
?>
<?php $csvBuilder->encode(array_merge(array($reportResults['columnNames']), $reportResults['rows']), false) ?>