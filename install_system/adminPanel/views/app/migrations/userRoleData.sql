SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO `user_role` (`id`, `name`, `slug`) VALUES
(1, 'Администратор', 'admin'),
(2, 'Пользователь', 'user'),
(3, 'Гость', 'goust');
COMMIT;
