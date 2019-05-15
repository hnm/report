<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use n2n\impl\web\dispatch\mag\model\BoolMag;

class BooleanQueryVariable extends QueryVariable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoDiscriminatorValue('boolean'));
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 * @return Mag
	 */
	public function createMag(): Mag {
		return new BoolMag($this->getLabel());
	}
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag) {
		return (bool) $mag->getValue();
	}
}