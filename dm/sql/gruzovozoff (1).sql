-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Июн 03 2025 г., 20:21
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gruzovozoff`
--

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `dimensions` varchar(50) NOT NULL,
  `cargo_type` varchar(50) NOT NULL,
  `from_address` text NOT NULL,
  `to_address` text NOT NULL,
  `status` enum('Новая','В работе','Отменена') DEFAULT 'Новая',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_date`, `weight`, `dimensions`, `cargo_type`, `from_address`, `to_address`, `status`, `created_at`) VALUES
(1, 2, '2025-06-03 17:07:00', '505.00', '1.6', 'хрупкое', '123321', '3123', 'В работе', '2025-06-03 12:08:07');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `full_name`, `phone`, `email`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$SOMEHASH', 'Администратор', '+7(999)-999-99-99', 'admin@gruzovozoff.ru', '2025-06-03 10:39:01', 'admin'),
(2, 'Никита', '$2y$10$Wp/wQGiORNjoJXHG0HpmluFUTs04p3zsS5w/tx3dUpdkvQXvKiUJm', 'Тарасов Никита Александрович', '89670779292', 'plaerk123@gmail.com', '2025-06-03 11:59:32', 'user'),
(3, 'Алина', '$2y$10$S9kdU2MdIR1V/RWA2v9..exxNePL8mpLOgt.tKzZGBQVCMZLUJUTm', 'ОП По Го', '89670779292', 'nikita@admin.com', '2025-06-03 12:16:01', 'admin'),
(4, 'Юля', '$2y$10$jpCodgUM9nlv3BZ9GcfMT.KkdzsEWIe17jKQbRuGFTXvQRWQXHasG', 'Нина Там Сям', '89670779292', 'aaaa@admin.ru', '2025-06-03 12:27:45', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
