<?php
namespace report\bo;

use n2n\reflection\annotation\AnnoInit;
use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\web\dispatch\mag\Mag;
use n2n\impl\web\dispatch\mag\model\NumericMag;

class NumericQueryVariable extends QueryVariable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoDiscriminatorValue('numeric'));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 */
	public function createMag(): Mag {
		return new NumericMag($this->getName(), $this->getLabel());
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag) {
		return $mag->getFormValue();
	}
	
}