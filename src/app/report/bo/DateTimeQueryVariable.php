<?php
namespace report\bo;

use n2n\impl\web\dispatch\mag\model\DateTimeMag;
use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use rocket\attribute\EiType;
use n2n\persistence\orm\attribute\DiscriminatorValue;

#[EiType(label: 'Datum/Zeit Variable', pluralLabel: 'Datum/Zeit Variablen')]
#[DiscriminatorValue('date-time')]
class DateTimeQueryVariable extends QueryVariable {

	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 * @return Mag
	 */
	public function createMag(): Mag {
		return new DateTimeMag($this->getLabel());
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag): \DateTime {
		return $mag->getFormValue();
	}
	
}