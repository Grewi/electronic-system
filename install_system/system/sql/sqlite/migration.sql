CREATE TABLE `migrations` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` varchar(255) NOT NULL,
    `active` timestamp NULL DEFAULT NULL
);