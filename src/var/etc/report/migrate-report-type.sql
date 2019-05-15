ALTER TABLE `report`
	ADD COLUMN `type` VARCHAR(255) NOT NULL DEFAULT 'nql' AFTER `name`;
ALTER TABLE `report`
	CHANGE COLUMN `nql_query` `query` TEXT NULL AFTER `type`;