CREATE TABLE `PackageStatus` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `statusName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;