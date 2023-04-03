<?php
namespace report\util;

use n2n\l10n\L10nUtils;
use n2n\util\type\CastUtils;
use n2n\util\StringUtils;
use rocket\core\model\Rocket;
use n2n\l10n\N2nLocale;
use n2n\persistence\orm\OrmConfigurationException;
use rocket\ei\util\Eiu;

class ReportUtils {
	
	/**
	 * @param string $string
	 * @return boolean
	 */
	public static function containsHtml($string) {
		if (empty($string)) {
			return false;
		}
		
		return $string != strip_tags($string);
	}
	
	/**
	 * @param mixed $value
	 * @param Eiu $eiu
	 * @return mixed|null
	 */
	public static function determineValueByType($value, Eiu $eiu) {
		$locale = $eiu->frame()->getN2nLocale();
		
		if (is_scalar($value)) {
			return $value;
		}
		
		if ($value instanceof \DateTime) {
			return L10nUtils::formatDateTime($value, $locale);
		}
		
		if ($value instanceof N2nLocale) {
			return $value->getName();
		}
		
		if (is_object($value)) {
			$entityModel = null;
			try {
				$entityModel = $eiu->frame()->em()->getEntityModelManager()->getEntityModelByEntityObj($value);
			} catch (OrmConfigurationException $e) {
				try {
					return StringUtils::strOf($value);
				} catch (\InvalidArgumentException $e) {
					return '[obj]';
				}
			}
				
			$rocket = $eiu->frame()->getN2nContext()->lookup(Rocket::class);
			CastUtils::assertTrue($rocket instanceof Rocket);
				
			if (!$rocket->getSpec()->containsEiTypeClass($entityModel->getClass())) {
				return '[obj]';
			}
				
			$eiSpec = $rocket->getSpec()->getEiTypeByClass($entityModel->getClass());
			$valueEiu = new Eiu($eiSpec, $eiu->getN2nContext(), $value);
			return $valueEiu->entry()->createIdentityString();
		}
		
		return null;
	}
}
