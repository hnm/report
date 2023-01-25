<?php
namespace report\bo;

use n2n\impl\web\dispatch\mag\model\StringMag;
use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use rocket\attribute\EiType;

#[EiType(label: 'String Variable', pluralLabel: 'String Variablen')]
class StringQueryVariable extends QueryVariable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoDiscriminatorValue('string'));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 */
	public function createMag(): Mag {
		return new StringMag($this->getLabel());
	}
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag) {
		return (string) $mag->getFormValue();
	}
}