<?php
namespace report\rocket\controller;

use n2n\impl\web\dispatch\mag\model\MagForm;
use n2n\l10n\DynamicTextCollection;
use n2n\util\type\CastUtils;
use n2n\web\dispatch\mag\MagCollection;
use n2n\web\http\controller\ControllerAdapter;
use n2n\web\http\controller\ParamPost;
use n2n\web\http\Request;
use report\bo\Report;
use report\model\ReportDao;
use report\util\ReportUtils;
use rocket\op\OpState;
use rocket\op\util\OpuCtrl;
use rocket\op\ei\util\Eiu;
use n2n\util\io\IoUtils;

class RunReportController extends ControllerAdapter {
	
	const COMMAND_REPORT = 'run';
	const COMMAND_CSV = 'csv';
	
	private $opuCtrl;
	/**
	 * @var Eiu $eiu
	 */
	private $eiu;
	/**
	 * @var OpState $rocketState
	 */
	private $rocketState;
	/**
	 * @var DynamicTextCollection $dtc
	 */
	private $dtc;
	
	/**
	 * @param Eiu $eiu
	 * @param OpState $rocketState
	 * @param Request $request
	 */
	public function prepare(Request $request) {
		$this->opuCtrl = OpuCtrl::from($this->cu());
		$this->eiu = $this->opuCtrl->eiu();
		$this->dtc = $this->eiu->dtc('report');
	}
	
	function index($reportId) {
		$report = $this->opuCtrl->lookupObject($reportId);
		
		$this->opuCtrl->pushOverviewBreadcrumb()
				->pushDetailBreadcrumb($report)
				->pushCurrentAsSirefBreadcrumb($this->dtc->t('script_cmd_run_report_breadcrumb'));
		
		$this->opuCtrl->forwardUrlIframeZone($this->getUrlToController(['src', $reportId]));
	}
	
	/**
	 * @param ParamPost $command
	 * @param ReportDao $reportDao
	 * @param string $reportId
	 */
	public function doSrc(ReportDao $reportDao, $reportId, ParamPost $command = null) {
		$reportResults = array();
		$reportGenerated = false;
		
		$report = $this->opuCtrl->lookupEntry($reportId)->getEntityObj();
		CastUtils::assertTrue($report instanceof Report);
		
		$hasQueryVariables = $report->hasQueryVariables();
		
		$magCollection = new MagCollection();		
		foreach ($report->getVariables() as $key => $queryVariable) {
			$magCollection->addMag($queryVariable->getName(), $queryVariable->createMag($key));
		}
		
		$magForm = new MagForm($magCollection);
		if ($this->dispatch($magForm) || !$hasQueryVariables) {
			if (null !== $command) {
				$command = $command->toNotEmptyStringOrReject();
			}
			
			$reportResults = $reportDao->findReportResults($report, $this->eiu, $magCollection);
			if (null !== $reportResults) {
				$reportResults = $this->prepareReportResults($reportResults);
					
				if ($command === self::COMMAND_CSV) {
					$this->getResponse()->setHeader('Content-Disposition: attachment;filename="'
							. IoUtils::stripSpecialChars($report->getName()) . '.csv"');
					$this->forward('..\..\view\report.csv', array('reportResults' => $reportResults));
					return;
				}
				if ($command === self::COMMAND_REPORT || !$hasQueryVariables) {
					$reportGenerated = true;
				}
			}
		}
		
		$this->forward('..\..\view\reportForm.html', 
					array('magForm' => $magForm, 'report' => $report, 'reportGenerated' => $reportGenerated,
							'reportResults' => $reportResults));
	}

	private function prepareReportResults(\ArrayObject|array $reportResults): array {
		$counter = 0;
		$preparedReportResults = array();
		
		foreach ($reportResults as $reportResult) {
			if (!isset($preparedReportResults['columnNames'])) {
				if (is_object($reportResult)) {
					$classObject = get_class($reportResult);
					$preparedReportResults['columnNames'] = str_replace($classObject, '', array_keys((array) $reportResult));
				} else {
					// @todo: results must have nice column names
					$preparedReportResults['columnNames'] = array_keys((array) $reportResult);
				}
			}
			foreach ((array) $reportResult as $value) {
				$preparedReportResults['rows'][$counter][] = ReportUtils::determineValueByType($value, $this->eiu);
			}
			$counter++;
		}
		return $preparedReportResults;
	}
	
}