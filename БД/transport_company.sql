-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 07 2025 г., 15:13
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `transport company`
--

-- --------------------------------------------------------

--
-- Структура таблицы `маршрут`
--

CREATE TABLE `маршрут` (
  `Id(Маршрута)` int NOT NULL COMMENT 'Id уникального маршрута',
  `Наименование` varchar(255) NOT NULL COMMENT 'Город-город',
  `Тариф` float NOT NULL COMMENT 'За 1 кг',
  `Расстояние` int NOT NULL COMMENT 'Расстояние между городами'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица данных о маршрутах';

--
-- Дамп данных таблицы `маршрут`
--

INSERT INTO `маршрут` (`Id(Маршрута)`, `Наименование`, `Тариф`, `Расстояние`) VALUES
(1, 'Сургут-Нижневартовск', 500, 222),
(2, 'Сургут-Нефтеюганск', 700, 64),
(3, 'Сургут-Тюмень', 400, 787),
(4, 'Сургут-Лангепас', 600, 126),
(5, 'Сургут-Лянтор', 450, 92),
(6, 'Сургут-Ноябрьск', 350, 312);

-- --------------------------------------------------------

--
-- Структура таблицы `груз`
--

CREATE TABLE `груз` (
  `Id(груз)` int NOT NULL COMMENT 'Уникальный Id отправленного груза',
  `Рейс` int NOT NULL COMMENT 'Рейс из таблицы рейсов',
  `Вес` float NOT NULL COMMENT 'Вес груза',
  `Отправитель` varchar(255) NOT NULL COMMENT 'Название компании или ФИО отправителя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица для отображния информации о доставляемых грузах';

--
-- Дамп данных таблицы `груз`
--

INSERT INTO `груз` (`Id(груз)`, `Рейс`, `Вес`, `Отправитель`) VALUES
(1, 1, 3, 'ООО \"Печенька\"'),
(2, 2, 2, 'ООО \"Шоколадка\"'),
(3, 3, 1, 'ООО \"Кекс\"'),
(4, 4, 6, 'ООО \"Хм\"'),
(5, 5, 4, 'ООО \"Чтосюдаписать\"'),
(6, 6, 4, 'ООО \"Закончиласьфантазия\"');

-- --------------------------------------------------------

--
-- Структура таблицы `рейс`
--

CREATE TABLE `рейс` (
  `Id(Рейс)` int NOT NULL COMMENT 'Id рейса',
  `Маршрут` int NOT NULL COMMENT 'Маршрут из таблицы маршрутов',
  `Транспорт` int NOT NULL COMMENT 'Транспорт из таблицы транспортов',
  `Дата_Отправления` datetime NOT NULL COMMENT 'Дата и время отправления',
  `Дата_Прибытия` datetime NOT NULL COMMENT 'Дата и время прибытия'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `рейс`
--

INSERT INTO `рейс` (`Id(Рейс)`, `Маршрут`, `Транспорт`, `Дата_Отправления`, `Дата_Прибытия`) VALUES
(1, 1, 1, '2025-09-07 14:00:00', '2025-09-07 17:00:00'),
(2, 2, 2, '2025-09-10 14:00:00', '2025-09-11 16:00:00'),
(3, 3, 3, '2025-09-08 10:00:00', '2025-09-09 08:00:00'),
(4, 4, 4, '2025-09-07 14:00:00', '2025-09-07 17:00:00'),
(5, 5, 5, '2025-09-07 16:00:00', '2025-09-07 18:00:00'),
(6, 6, 6, '2025-09-07 12:00:50', '2025-09-07 17:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `транспорт`
--

CREATE TABLE `транспорт` (
  `Id(Транспорта)` int NOT NULL COMMENT 'Уникальный ID транспортного средства',
  `Наименование` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Наименование транспорта',
  `Грузоподъемность` float NOT NULL COMMENT 'Грузоподъемность транспорта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица данных о транспорте компании';

--
-- Дамп данных таблицы `транспорт`
--

INSERT INTO `транспорт` (`Id(Транспорта)`, `Наименование`, `Грузоподъемность`) VALUES
(1, 'Volvo FN', 5),
(2, 'Volvo F90', 7),
(3, 'Газель Next', 2),
(4, 'MAN F2000', 10),
(5, 'MAN F90', 12),
(6, 'MAN TGL', 6);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `маршрут`
--
ALTER TABLE `маршрут`
  ADD UNIQUE KEY `Уникальный маршрут` (`Id(Маршрута)`),
  ADD KEY `Id(Маршрута)` (`Id(Маршрута)`);

--
-- Индексы таблицы `груз`
--
ALTER TABLE `груз`
  ADD UNIQUE KEY `Id(груз)` (`Id(груз)`),
  ADD KEY `Рейс` (`Рейс`);

--
-- Индексы таблицы `рейс`
--
ALTER TABLE `рейс`
  ADD UNIQUE KEY `Id(Рейс)` (`Id(Рейс)`),
  ADD KEY `Маршрут` (`Маршрут`),
  ADD KEY `Транспорт` (`Транспорт`);

--
-- Индексы таблицы `транспорт`
--
ALTER TABLE `транспорт`
  ADD UNIQUE KEY `Id(Транспорта)` (`Id(Транспорта)`) USING BTREE;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `груз`
--
ALTER TABLE `груз`
  ADD CONSTRAINT `груз_ibfk_1` FOREIGN KEY (`Рейс`) REFERENCES `рейс` (`Id(Рейс)`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `рейс`
--
ALTER TABLE `рейс`
  ADD CONSTRAINT `рейс_ibfk_1` FOREIGN KEY (`Маршрут`) REFERENCES `маршрут` (`Id(Маршрута)`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `рейс_ibfk_2` FOREIGN KEY (`Транспорт`) REFERENCES `транспорт` (`Id(Транспорта)`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
