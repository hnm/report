<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use n2n\util\type\ArgUtils;
use n2n\impl\web\dispatch\mag\model\N2nLocaleMag;
use rocket\attribute\EiType;
use n2n\persistence\orm\attribute\DiscriminatorValue;

#[EiType(label: 'Locale Variable', pluralLabel: 'Locale Variablen')]
#[DiscriminatorValue('n2n-locale')]
class N2nLocaleQueryVariable extends QueryVariable {

	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 */
	public function createMag(): Mag {
		return new N2nLocaleMag($this->getLabel());
	}
	
	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag) {
		ArgUtils::assertTrue($mag instanceof N2nLocaleMag);
		return $mag->getValue();
	}
	
}