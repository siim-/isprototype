CREATE TABLE `PackageWarehouse` (
  `warehouseId` INT(10) UNSIGNED NULL,
  `packageId` INT(10) UNSIGNED NULL,
  `shelf` INT(10) UNSIGNED NULL,
  `position` INT(10) UNSIGNED NULL,
  CONSTRAINT `FK_package_warehouse_wh` FOREIGN KEY (`warehouseId`) REFERENCES `Warehouse` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `FK_package_warehouse_package` FOREIGN KEY (`packageId`) REFERENCES `Package` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `FK_package_warehouse_shelf` FOREIGN KEY (`shelf`) REFERENCES `Shelf` (`id`) ON UPDATE CASCADE
) COLLATE='utf8_general_ci' ENGINE=InnoDB;
