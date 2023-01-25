<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoDiscriminatorColumn;
use n2n\persistence\orm\annotation\AnnoInheritance;
use n2n\persistence\orm\annotation\AnnoManyToOne;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\persistence\orm\CascadeType;
use n2n\persistence\orm\InheritanceType;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;
use n2n\web\dispatch\mag\Mag;
use rocket\attribute\EiType;
use rocket\attribute\EiPreset;

#[EiType(pluralLabel: 'Query Variablen')]
#[EiPreset(editProps: ['label', 'name'])]
abstract class QueryVariable extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->p('report', new AnnoManyToOne(Report::getClass(), CascadeType::MERGE));
		$ai->c(new AnnoTable('report_query_variable'), new AnnoInheritance(InheritanceType::SINGLE_TABLE), new AnnoDiscriminatorColumn('type'));
	}
	
	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var string $label
	 */
	private string $label;
	/**
	 * @var string $name
	 */
	private string $name;

	/**
	 * @var Report $report
	 */
	private $report;
	
	/**
	 * @return string
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
	 * @return \report\bo\Report
	 */
	public function getReport() {
		return $this->report;
	}
	/**
	 * @param Report $report
	 */
	public function setReport(Report $report) {
		$this->report = $report;
	}
	/**
	 * @return Mag
	 */	
	abstract public function createMag(): Mag;
	/**
	 * @param Mag $mag
	 */
	abstract public function buildValue(Mag $mag);
}
