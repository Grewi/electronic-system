CREATE TABLE `images_categories` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `parent` int(11) DEFAULT NULL,
    `name` varchar(255) NOT NULL
);
