<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;

class Report extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('report'));
		$ai->p('variables', new AnnoOneToMany(QueryVariable::getClass(), 'report', \n2n\persistence\orm\CascadeType::ALL, null, true));
	}

	const TYPE_NQL = 'nql';
	const TYPE_SQL = 'sql';

	private $id;
	private $name;
	private $type = self::TYPE_NQL;
	private $query;
	private $variables;

	public function __construct() {
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
	public function setId(int $id = null) {
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
	public function setName(string $name = null) {
		$this->name = $name;
	}

	/**
	 * @return QueryVariable[]
	 */
	public function getVariables() {
		return $this->variables;
	}

	/**
	 * @param \ArrayObject $variables
	 */
	public function setVariables($variables) {
		$this->variables = $variables;
	}

	/**
	 * @return boolean
	 */
	public function hasQueryVariables() {
		return count($this->variables) > 0 ? true : false;
	}

	public function getType() {
		return $this->type;
	}

	public function setType(string $type) {
		$this->type = $type;
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery(string $query = null) {
		$this->query = $query;
	}
}