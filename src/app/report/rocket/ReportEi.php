<?php

namespace report\rocket;

use n2n\context\attribute\ThreadScoped;
use rocket\attribute\impl\EiSetup;
use rocket\impl\ei\component\cmd\EiCmdNatures;
use rocket\op\ei\util\Eiu;
use rocket\ui\si\control\SiButton;
use rocket\ui\si\control\SiIconType;
use report\rocket\controller\RunReportController;
use rocket\impl\ei\manage\gui\GuiControls;

#[ThreadScoped]
class ReportEi {

	#[EiSetup]
	function eiSetup(Eiu $eiu): void {
		$eiu->mask()->addCmd(EiCmdNatures::callback()
				->setController(fn (Eiu $eiu) => $eiu->lookup(RunReportController::class))
				->putEntryGuiControl('report', function (Eiu $eiu) {
					if ($eiu->entry()->isNew()) {
						return null;
					}

					$dtc = $eiu->dtc('report');

					return GuiControls::ref($eiu->frame()->getCmdUrl()->pathExt($eiu->entry()->getPid()),
							SiButton::secondary($dtc->t('script_cmd_run_report_label'), SiIconType::ICON_PLAY)
									->setTooltip($dtc->t('script_cmd_run_report_tooltip', array('entry' => $eiu->frame()->getGenericLabel())))
									->setImportant(true));
				}));
	}
}