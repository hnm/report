<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\CascadeType;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;

class EnumValue extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('report_enum_value'));
		$ai->p('enumQueryVariable', new AnnoManyToOne(EnumQueryVariable::getClass(), CascadeType::ALL));
	}
	
	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var string $key
	 */
	private $key;
	/**
	 * @var string $label
	 */
	private $label;
	/**
	 * @var EnumQueryVariable $enumQueryVariable
	 */
	private $enumQueryVariable;

	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}
	
	/**
	 * @param string $key
	 */
	public function setKey(string $key){
		$this->key = $key;
	}
	
	/**
	 * @return string $label
	 */
	public function getLabel() {
		return $this->label;
	}
	
	/**
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return EnumQueryVariable
	 */
	public function getEnumQueryVariable() {
		return $this->enumQueryVariable;
	}
	
	/**
	 * @param EnumQueryVariable $enumQueryVariable
	 */
	public function setEnumQueryVariable(EnumQueryVariable $enumQueryVariable) {
		$this->enumQueryVariable = $enumQueryVariable;
	}
}