<?php
namespace report\ei\command;

use n2n\l10n\DynamicTextCollection;
use report\ei\controller\RunReportController;
use rocket\impl\ei\component\command\IndependentEiCommandAdapter;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\util\uri\Path;
use n2n\l10n\N2nLocale;
use n2n\web\http\controller\Controller;
use rocket\ei\component\command\control\EntryControlComponent;
use rocket\ei\util\Eiu;
use n2n\core\container\N2nContext;
use rocket\ei\manage\control\ControlButton;
use rocket\ei\manage\control\IconType;
use rocket\ei\manage\control\HrefControl;

class RunReportScriptCommand extends IndependentEiCommandAdapter implements EntryControlComponent {
	const DEFAULT_ID = 'run-report';
	const CONTROL_DETAIL_KEY = 'report';
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\impl\ei\component\EiComponentAdapter::getIdBase()
	 */
	public function getIdBase(): ?string {
		return self::DEFAULT_ID;
	}
	
	/**
	 * @return string
	 */
	public function getTypeName(): string {
		return 'Run Report';
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\EiCommand::lookupController()
	 */
	public function lookupController(Eiu $eiu): Controller {
		return $eiu->lookup(RunReportController::class);
	}

	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\control\EntryControlComponent::getEntryControlOptions()
	 */
	public function getEntryControlOptions(N2nContext $n2nContext, N2nLocale $n2nLocale): array {
		$dtc = new DynamicTextCollection('report', $n2nLocale);
		return array(self::DEFAULT_ID => $dtc->translate('script_cmd_export_report_label'));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \rocket\ei\component\command\control\EntryControlComponent::createEntryControls()
	 */
	public function createEntryControls(Eiu $eiu, HtmlView $view): array {
		$eiuFrame = $eiu->frame();
		$controlButton = new ControlButton(
				$view->getL10nText('script_cmd_run_report_label', null, null, null, 'report'), $view->getL10nText('script_cmd_run_report_tooltip',
						array('entry' => $eiuFrame->getGenericLabel()), null, null, 'report'),
				true, ControlButton::TYPE_SECONDARY, IconType::ICON_PLAY);
	
		$urlExt = (new Path(array($eiu->entry()->getLiveId())))->toUrl();
		return array(self::CONTROL_DETAIL_KEY
				=> HrefControl::create($eiuFrame->getEiFrame(), $this, $urlExt, $controlButton));
	}
}