CREATE TABLE `UserRole` (
  `user_id` INT(10) UNSIGNED NOT NULL,
  `role_id` INT(10) UNSIGNED NOT NULL,
  CONSTRAINT `FK_user_role_user` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `FK_user_role_role` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) COLLATE='utf8_general_ci' ENGINE=InnoDB;