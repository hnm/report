<?php
//namespace report\ei\command;
//
//use rocket\impl\ei\component\command\adapter\IndependentEiCommandAdapter;
//use rocket\op\ei\util\Eiu;
//use rocket\si\control\SiButton;
//use rocket\si\control\SiIconType;
//use n2n\util\uri\Path;
//use report\ei\controller\RunReportController;
//use n2n\web\http\controller\Controller;
//
//class RunReportScriptCommand extends IndependentEiCommandAdapter {
//	const DEFAULT_ID = 'run-report';
//	const CONTROL_DETAIL_KEY = 'report';
//
//	/**
//	 * {@inheritDoc}
//	 * @see \rocket\impl\ei\component\EiComponentAdapter::getIdBase()
//	 */
//	public function getIdBase(): ?string {
//		return self::DEFAULT_ID;
//	}
//
//	protected function prepare() {
//	}
//
//
//// 	/**
//// 	 * @return string
//// 	 */
//// 	public function getTypeName(): string {
//// 		return 'Run Report';
//// 	}
//
//	/**
//	 * {@inheritDoc}
//	 * @see \rocket\op\ei\component\command\EiCommand::lookupController()
//	 */
//	public function lookupController(Eiu $eiu): Controller {
//		return $eiu->lookup(RunReportController::class);
//	}
//
//
//// 	public function getEntryGuiControlOptions(N2nContext $n2nContext, N2nLocale $n2nLocale): array {
//// 		$dtc = new DynamicTextCollection('report', $n2nLocale);
//// 		return array(self::DEFAULT_ID => $dtc->translate('script_cmd_export_report_label'));
//// 	}
//
//	public function createEntryGuiControls(Eiu $eiu): array {
//		$eiuEntry = $eiu->entry();
//
//		if ($eiuEntry->isNew() || $eiu->frame()->isExecutedBy($this)) {
//			return array();
//		}
//
//
//
//		$eiuControlFactory = $eiu->factory()->guiControl();
//
//		return [$eiuControlFactory->newCmdRef(self::CONTROL_DETAIL_KEY, $siButton,
//				new Path([$eiu->entry()->getPid()]))];
//	}
//
//
//// 	public function createEntryGuiControls(Eiu $eiu): array {
//// 		$eiuFrame = $eiu->frame();
//// 		$siButton = new SiButton(
//// 				$view->getL10nText('script_cmd_run_report_label', null, null, null, 'report'),
//// 				$view->getL10nText('script_cmd_run_report_tooltip',
//// 						array('entry' => $eiuFrame->getGenericLabel()), null, null, 'report'),
//// 				true, SiButton::TYPE_SECONDARY, SiIconType::ICON_PLAY);
//
//// 		$urlExt = (new Path(array($eiu->entry()->getId())))->toUrl();
//// 		return array(self::CONTROL_DETAIL_KEY
//// 				=> HrefControl::create($eiuFrame->getEiFrame(), $this, $urlExt, $siButton));
//// 	}
//}