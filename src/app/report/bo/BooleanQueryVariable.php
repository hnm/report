<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use n2n\impl\web\dispatch\mag\model\BoolMag;
use rocket\attribute\EiType;
use n2n\persistence\orm\attribute\DiscriminatorValue;

#[EiType(label: 'Wahr/Falsch Variable', pluralLabel: 'Wahr/Falsch Variabeln')]
#[DiscriminatorValue('boolean')]
class BooleanQueryVariable extends QueryVariable {
	
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
	public function buildValue(Mag $mag): bool {
		return (bool) $mag->getValue();
	}
}