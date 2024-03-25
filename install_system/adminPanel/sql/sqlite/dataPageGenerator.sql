CREATE TABLE `data_page_generator` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `page_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `data` longtext NOT NULL
);