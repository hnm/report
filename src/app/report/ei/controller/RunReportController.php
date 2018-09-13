<?php
namespace report\ei\controller;

use n2n\impl\web\dispatch\mag\model\MagForm;
use n2n\io\IoUtils;
use n2n\l10n\DynamicTextCollection;
use n2n\reflection\CastUtils;
use n2n\web\dispatch\mag\MagCollection;
use n2n\web\http\controller\ControllerAdapter;
use n2n\web\http\controller\ParamPost;
use n2n\web\http\Request;
use report\bo\Report;
use report\model\ReportDao;
use report\util\ReportUtils;
use rocket\core\model\Breadcrumb;
use rocket\core\model\RocketState;
use rocket\ei\util\EiuCtrl;
use rocket\ei\util\Eiu;

class RunReportController extends ControllerAdapter {
	
	const COMMAND_REPORT = 'run';
	const COMMAND_CSV = 'csv';
	
	private $eiuCtrl;
	/**
	 * @var Eiu $eiu
	 */
	private $eiu;
	/**
	 * @var RocketState $rocketState
	 */
	private $rocketState;
	/**
	 * @var DynamicTextCollection $dtc
	 */
	private $dtc;
	
	/**
	 * @param Eiu $eiu
	 * @param RocketState $rocketState
	 * @param Request $request
	 */
	public function prepare(EiuCtrl $eiuCtrl, RocketState $rocketState, Request $request) {
		$this->eiuCtrl = $eiuCtrl;
		$this->eiu = $eiuCtrl->eiu();
		$this->rocketState = $rocketState;
		$this->dtc = new DynamicTextCollection('report', $request->getN2nLocale());
	}
	
	/**
	 * @param ParamPost $command
	 * @param ReportDao $reportDao
	 * @param string $reportId
	 */
	public function index(ParamPost $command = null, ReportDao $reportDao, $reportId) {
		$reportResults = array();
		$reportGenerated = false;
		
		$report = $this->eiuCtrl->lookupEntry($reportId)->getEntityObj();
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
		
		$this->applyBreadcrumbs($reportId);
		$this->forward('..\..\view\reportForm.html', 
					array('magForm' => $magForm, 'report' => $report, 'reportGenerated' => $reportGenerated,
							'reportResults' => $reportResults));
	}
	
	/**
	 * @param \ArrayObject $reportResults
	 * @return array
	 */
	private function prepareReportResults($reportResults) {
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
	
	/**
	 * @param string $reportId
	 */
	private function applyBreadcrumbs($reportId) {
		$controllerContext = $this->getControllerContext();
		$httpContext = $this->getHttpContext();
	
		$EiFrame = $this->eiu->frame()->getEiFrame();
		$eiObject = $this->eiuCtrl->lookupEntry($reportId)->getEiObject();
	
		if (!$EiFrame->isOverviewDisabled()) {
			$this->rocketState->addBreadcrumb($EiFrame->createOverviewBreadcrumb($httpContext));
		}
	
		$this->rocketState->addBreadcrumb($EiFrame->createDetailBreadcrumb($httpContext, $eiObject));
		$this->rocketState->addBreadcrumb(new Breadcrumb($httpContext->getControllerContextPath($controllerContext), 
				$this->dtc->translate('script_cmd_run_report_breadcrumb')));
	}
}