CREATE TABLE `images` (
    `id` int(11) NOT NULL,
    `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `category_id` int(11) DEFAULT NULL,
    `blog_id` int(11) DEFAULT NULL,
    `post_id` int(11) DEFAULT NULL,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `description` varchar(1024) DEFAULT NULL,
    `active` tinyint(1) NOT NULL DEFAULT 1,
    `date_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

CREATE TABLE `images_categories` (
    `id` int(11) NOT NULL,
    `parent` int(11) DEFAULT NULL,
    `name` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

CREATE TABLE `image_size` (
    `id` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `size` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

INSERT INTO
    `image_size` (`id`, `name`, `slug`, `size`)
VALUES
    (1, 'icon', 'icon', 100),
    (2, 'mini', 'mini', 250),
    (3, 'normal', 'normal', 500),
    (4, 'big', 'big', 1000);

ALTER TABLE `images`
ADD PRIMARY KEY (`id`),
ADD KEY `blog_id` (`blog_id`),
ADD KEY `post_id` (`post_id`),
ADD KEY `category_id` (`category_id`);

ALTER TABLE `images_categories`
ADD PRIMARY KEY (`id`),
ADD KEY `parent` (`parent`);

ALTER TABLE `image_size`
ADD PRIMARY KEY (`id`);

ALTER TABLE `images`
MODIFY`id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `images_categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `image_size`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `images`
ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `images_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `images_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `images_categories`
ADD CONSTRAINT `images_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `images_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
