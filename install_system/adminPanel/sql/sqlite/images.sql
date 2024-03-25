CREATE TABLE `images` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `url` varchar(255)  DEFAULT NULL,
    `category_id` int(11) DEFAULT NULL,
    `blog_id` int(11) DEFAULT NULL,
    `post_id` int(11) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `description` varchar(1024) DEFAULT NULL,
    `active` tinyint(1) NOT NULL DEFAULT 1,
    `date_create` timestamp NOT NULL DEFAULT current_timestamp
);