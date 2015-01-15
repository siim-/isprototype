CREATE TABLE `Session` (
  `hash` VARCHAR(50) NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `created` DATETIME NOT NULL,
  PRIMARY KEY (`hash`),
  INDEX `FK_user_session` (`user_id`),
  CONSTRAINT `FK_user_session` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)