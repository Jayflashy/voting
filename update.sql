ALTER TABLE `settings` CHANGE `facebook` `banner` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `payments` ADD `country` VARCHAR(250) NULL AFTER `name`;
ALTER TABLE `settings` ADD `currency2` VARCHAR(50) NULL AFTER `currency_code`, ADD `currency_rate` VARCHAR(50) NULL AFTER `currency2`;
ALTER TABLE `settings` ADD `currency_code2` VARCHAR(100) NULL AFTER `currency2`;

