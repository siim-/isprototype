CREATE TABLE `Shelf` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `warehouseId` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `notes` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_shelf_warehouse` FOREIGN KEY (`warehouseId`) REFERENCES `Warehouse` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) COLLATE='utf8_general_ci' ENGINE=InnoDB;