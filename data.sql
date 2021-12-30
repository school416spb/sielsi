-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Дек 30 2021 г., 13:15
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `denedao5_sign`
--

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--
-- Создание: Дек 30 2021 г., 09:07
-- Последнее обновление: Дек 30 2021 г., 09:25
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id` int(10) NOT NULL,
  `password` varchar(20) NOT NULL COMMENT 'пароль',
  `school1` text NOT NULL COMMENT 'Первая часть названия',
  `school2` text NOT NULL COMMENT 'Вторая часть названия',
  `school3` text NOT NULL COMMENT 'Третья часть названия',
  `position` varchar(50) NOT NULL COMMENT 'Должность',
  `name` varchar(100) NOT NULL COMMENT 'ФИО директора',
  `site` varchar(50) NOT NULL COMMENT 'Адрес сайта',
  `inn` varchar(15) NOT NULL COMMENT 'ИНН организации',
  `red` int(3) NOT NULL COMMENT 'RGB красный',
  `green` int(3) NOT NULL COMMENT 'RGB зеленый',
  `blue` int(3) NOT NULL COMMENT 'RGB синий'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `data`
--

INSERT INTO `data` (`id`, `password`, `school1`, `school2`, `school3`, `position`, `name`, `site`, `inn`, `red`, `green`, `blue`) VALUES
(1, '12345678', 'ГБОУ средняя общеобразовательная школа № 416', 'Петродворцового района Санкт-Петербурга', '', 'директор школы', 'Ивашкина Наталья Евгеньевна', 'https://school416spb.ru', '7819018130', 0, 0, 255);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `data`
--
ALTER TABLE `data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
