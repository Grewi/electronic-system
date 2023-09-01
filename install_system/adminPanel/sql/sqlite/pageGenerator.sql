CREATE TABLE `page_generator` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `url` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp
);