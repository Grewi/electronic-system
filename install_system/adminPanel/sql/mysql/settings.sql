SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_category_id` int(11) NOT NULL,
  `setting_type_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `settings_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings_category` (`id`, `name`) VALUES
(1, 'Базовые настройки');

CREATE TABLE `settings_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings_type` (`id`, `name`) VALUES
(1, 'input'),
(2, 'checkbox');


ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_category_id` (`setting_category_id`),
  ADD KEY `setting_type_id` (`setting_type_id`);

ALTER TABLE `settings_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings_type`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `settings_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`setting_category_id`) REFERENCES `settings_category` (`id`),
  ADD CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`setting_type_id`) REFERENCES `settings_type` (`id`);
COMMIT;