<?php
namespace report\model;

use n2n\persistence\orm\EntityManager;
use report\bo\Report;
use n2n\context\RequestScoped;
use n2n\web\dispatch\mag\MagCollection;
use n2n\l10n\MessageContainer;
use n2n\persistence\orm\query\QueryConflictException;
use rocket\ei\util\Eiu;

class ReportDao implements RequestScoped {
	
	/**
	 * @var EntityManager $em
	 */
	private $em;
	
	/**
	 * @var MessageContainer $mc
	 */
	private $mc;
	
	private function _init(EntityManager $em, MessageContainer $mc) {
		$this->em = $em;
		$this->mc = $mc;
	}
	
	/**
	 * @param int $id
	 * @return Report
	 */
	public function getReportById($id) {
		return $this->em->find(Report::getClass(), $id);
	}

	/**
	 * @param Report $report
	 * @param Eiu $eiu
	 * @param MagCollection $magCollection
	 * @return array|NULL
	 */
	public function findReportResults(Report $report, Eiu $eiu, MagCollection $magCollection) {
		$bindValues = array();
		
		foreach ($report->getVariables() as $queryVariable) {
			$magPropertyName = $queryVariable->getName();
			$bindValues[$magPropertyName] = $queryVariable->buildValue($magCollection->getMagByPropertyName($magPropertyName));
		}

		try {
			$criteria = $eiu->frame()->em()->createNqlCriteria($report->getNqlQuery(), $bindValues);
			return $criteria->toQuery()->fetchArray();
		} catch (QueryConflictException $e) {
			$this->mc->addError($e->getMessage());
		}
	}
}