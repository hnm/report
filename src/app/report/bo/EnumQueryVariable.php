<?php
namespace report\bo;

use n2n\impl\web\dispatch\mag\model\EnumMag;
use n2n\persistence\orm\annotation\AnnoDiscriminatorValue;
use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\CascadeType;
use n2n\reflection\annotation\AnnoInit;
use n2n\web\dispatch\mag\Mag;
use rocket\attribute\impl\EiPropOneToManyEmbedded;
use rocket\attribute\EiType;

#[EiType(label: 'Locale Variable', pluralLabel: 'Locale Variablen')]
class EnumQueryVariable extends QueryVariable {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoDiscriminatorValue('enum'));
		$ai->p('enumValues', new AnnoOneToMany(EnumValue::getClass(), 'enumQueryVariable', 
					CascadeType::ALL, null, true));
	}
	

	#[EiPropOneToManyEmbedded]
	private \ArrayObject $enumValues;

	function __construct() {
		$this->enumValues = new \ArrayObject();
	}

	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::createMag()
	 */
	public function createMag(): Mag {
		$enumArr = array();
		foreach ($this->getEnumValues() as $enumValue) {
			$enumArr[$enumValue->getKey()] = $enumValue->getLabel();
		}
		return new EnumMag($this->getLabel(), $enumArr, null, false);
	}

	/**
	 * {@inheritDoc}
	 * @see \report\bo\QueryVariable::buildValue()
	 */
	public function buildValue(Mag $mag) {
		return $mag->getFormValue();
	}
	
	/**
	 * @return EnumValue []
	 */
	public function getEnumValues() {
		return $this->enumValues;
	}
	
	/**
	 * @param \ArrayObject $enumValues
	 */
	public function setEnumValues(\ArrayObject $enumValues) {
		$this->enumValues = $enumValues;
	}

}