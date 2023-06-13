<?php
namespace report\bo;

use n2n\persistence\orm\annotation\AnnoOneToMany;
use n2n\persistence\orm\annotation\AnnoTable;
use n2n\reflection\annotation\AnnoInit;
use n2n\reflection\ObjectAdapter;
use rocket\attribute\EiType;
use rocket\attribute\EiMenuItem;
use rocket\attribute\EiPreset;
use rocket\op\spec\setup\EiPresetMode;
use rocket\attribute\impl\EiPropOneToManyEmbedded;
use rocket\attribute\impl\EiPropEnum;
use rocket\attribute\impl\EiModCallback;
use report\rocket\ReportEi;
use rocket\attribute\impl\EiPropString;
use rocket\attribute\EiDisplayScheme;

#[EiType(label: 'Report', pluralLabel: 'Reports')]
#[EiMenuItem(groupName: 'Tools', groupOrderIndex: 999)]
#[EiPreset(EiPresetMode::EDIT, readProps: ['id'])]
#[EiModCallback(ReportEi::class)]
#[EiDisplayScheme(['name', 'type'])]
class Report extends ObjectAdapter {
	private static function _annos(AnnoInit $ai) {
		$ai->c(new AnnoTable('report'));
		$ai->p('variables', new AnnoOneToMany(QueryVariable::getClass(), 'report', \n2n\persistence\orm\CascadeType::ALL, null, true));
	}

	const TYPE_NQL = 'nql';
	const TYPE_SQL = 'sql';

	private int $id;
	private string $name;
	#[EiPropEnum([self::TYPE_NQL => 'NQL', self::TYPE_SQL => 'SQL'])]
	private string $type = self::TYPE_NQL;
	#[EiPropString(multiline: true)]
	private string $query;
	#[EiPropOneToManyEmbedded(reduced: true)]
	private \ArrayObject $variables;

	public function __construct() {
		$this->variables = new \ArrayObject();
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id ?? null;
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
		return $this->name ?? null;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name = null) {
		$this->name = $name;
	}

	public function getVariables(): \ArrayObject {
		return $this->variables;
	}

	public function setVariables(\ArrayObject $variables) {
		$this->variables = $variables;
	}

	public function hasQueryVariables(): bool {
		return count($this->variables) > 0 ? true : false;
	}

	public function getType() {
		return $this->type;
	}

	public function setType(string $type) {
		$this->type = $type;
	}

	public function getQuery() {
		return $this->query ?? null;
	}

	public function setQuery(string $query = null) {
		$this->query = $query;
	}
}