<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\CascadeType;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;

class Report extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('report'));
		$ai->p('variables', new AnnoOneToMany(QueryVariable::getClass(), 'report', CascadeType::ALL, null, true));
	}
	
	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var string $name
	 */
	private $name;
	/**
	 * @var string $nqlQuery
	 */
	private $nqlQuery;
	
	/**
	 * @var \ArrayObject QueryVariable
	 */
	private $variables;
	
	
	public function __construct(){
		$this->variables = new \ArrayObject();
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
	/**	
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	/**
	 * @return string
	 */
	public function getNqlQuery() {
		return $this->nqlQuery;
	}
	/**
	 * @param string $nqlQuery
	 */
	public function setNqlQuery($nqlQuery) {
		$this->nqlQuery = $nqlQuery;
	}
	/**
	 * @return \report\bo\QueryVariable[]
	 */
	public function getVariables() {
		return $this->variables;
	}
	
	/**
	 * @param \ArrayObject $variables
	 */
	public function setVariables(\ArrayObject $variables) {
		$this->variables = $variables;
	}
	
	/**
	 * @return boolean
	 */
	public function hasQueryVariables() {
		return count($this->variables) > 0 ? true : false;
	}
}