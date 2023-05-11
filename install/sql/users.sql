SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_code` int(5) DEFAULT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `user_role_id` int(11) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `email`, `email_code`, `email_status`, `password`, `name`, `login`, `active`, `user_role_id`, `date_create`) VALUES
(1, 'test@test.ru', 0000, 1, '$2y$10$CgcnD9KQqVjnmUH87/rqBuemv94y8lfzGgLXU3UvoeznI9TL9q3Gm', 'Евгений', NULL, 1, 1, '2022-10-21 05:54:22');


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

