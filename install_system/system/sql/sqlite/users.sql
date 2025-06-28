CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `email` varchar(255) NOT NULL,
  `email_code` int(5) DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp
);