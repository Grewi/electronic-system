SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
    time_zone = "+00:00";

CREATE TABLE `migrations` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `active` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

ALTER TABLE
    `migrations`
ADD
    PRIMARY KEY (`id`);

ALTER TABLE
    `migrations`
MODIFY
    `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;