-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 05 2020 г., 19:18
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `stephub_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `announcement_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `announcement`
--

INSERT INTO `announcement` (`id`, `owner_id`, `title`, `details`, `file`, `date`, `deadline`, `announcement_status_id`) VALUES
(1, 1, '', 'qwe', 'asdf', '2020-03-03', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `announcement_status`
--

CREATE TABLE `announcement_status` (
  `id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `announcement_status`
--

INSERT INTO `announcement_status` (`id`, `status`) VALUES
(1, 'actual'),
(2, 'frozen'),
(3, 'solved'),
(4, 'banned');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `login` varchar(45) NOT NULL,
  `telegram_username` varchar(45) NOT NULL,
  `student_num` varchar(45) NOT NULL,
  `user_status_id` int(11) NOT NULL,
  `is_online` tinyint(1) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `login`, `telegram_username`, `student_num`, `user_status_id`, `is_online`, `token`) VALUES
(1, '1', 'asdfg', '1', '1', '1', 1, 1, '1'),
(10, 'a', 'a', 'a', 'a', 'a', 1, 0, 'avsrdfvc'),
(17, '', '', '', '', '', 1, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `user_status`
--

CREATE TABLE `user_status` (
  `id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_status`
--

INSERT INTO `user_status` (`id`, `status`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'moderator'),
(4, 'banned');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `announcement_status`
--
ALTER TABLE `announcement_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_num` (`student_num`),
  ADD UNIQUE KEY `email` (`email`,`login`,`student_num`),
  ADD UNIQUE KEY `telegram_username` (`telegram_username`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `announcement_status`
--
ALTER TABLE `announcement_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
