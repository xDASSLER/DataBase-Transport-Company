-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 03 2026 г., 16:28
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
-- Структура таблицы `login_password`
--

CREATE TABLE `login_password` (
  `Id(LP)` int NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Должность` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `login_password`
--

INSERT INTO `login_password` (`Id(LP)`, `Login`, `Password`, `Должность`) VALUES
(1, 'Admin', 'root', 'Администратор'),
(3, 'Operator', 'root', 'Оператор');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `Id` int NOT NULL,
  `Статус` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`Id`, `Статус`) VALUES
(1, 'Выполняется'),
(2, 'Выполнен'),
(3, 'Ожидание');

-- --------------------------------------------------------

--
-- Структура таблицы `маршрут`
--

CREATE TABLE `маршрут` (
  `Id` int NOT NULL COMMENT 'Id уникального маршрута',
  `Наименование` varchar(255) NOT NULL COMMENT 'Город-город',
  `Тариф` float NOT NULL COMMENT 'За 1 кг',
  `Расстояние` int NOT NULL COMMENT 'Расстояние между городами'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица данных о маршрутах';

--
-- Дамп данных таблицы `маршрут`
--

INSERT INTO `маршрут` (`Id`, `Наименование`, `Тариф`, `Расстояние`) VALUES
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
  `Id` int NOT NULL COMMENT 'Уникальный Id отправленного груза',
  `Рейс` int NOT NULL COMMENT 'Рейс из таблицы рейсов',
  `Вес` float NOT NULL COMMENT 'Вес груза',
  `Отправитель` varchar(255) NOT NULL COMMENT 'Название компании или ФИО отправителя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица для отображния информации о доставляемых грузах';

--
-- Дамп данных таблицы `груз`
--

INSERT INTO `груз` (`Id`, `Рейс`, `Вес`, `Отправитель`) VALUES
(1, 1, 5, 'ООО \"Шоколадка\"'),
(2, 2, 3, 'ООО \"Котлета\"'),
(3, 3, 2, 'ООО \"Конструкция\"');

-- --------------------------------------------------------

--
-- Структура таблицы `рейс`
--

CREATE TABLE `рейс` (
  `Id` int NOT NULL COMMENT 'Id рейса',
  `Маршрут` int NOT NULL COMMENT 'Маршрут из таблицы маршрутов',
  `Транспорт` int NOT NULL COMMENT 'Транспорт из таблицы транспортов',
  `Дата_Отправления` datetime DEFAULT NULL COMMENT 'Дата и время отправления',
  `Дата_Прибытия` datetime DEFAULT NULL COMMENT 'Дата и время прибытия',
  `Статус` int NOT NULL COMMENT 'Отображает статус рейса'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `рейс`
--

INSERT INTO `рейс` (`Id`, `Маршрут`, `Транспорт`, `Дата_Отправления`, `Дата_Прибытия`, `Статус`) VALUES
(1, 1, 1, '2026-02-27 08:00:00', '2026-03-01 09:00:00', 2),
(2, 2, 2, '2026-02-27 09:00:00', '2026-02-28 18:30:00', 2),
(3, 3, 3, '2026-02-28 08:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `транспорт`
--

CREATE TABLE `транспорт` (
  `Id` int NOT NULL COMMENT 'Уникальный ID транспортного средства',
  `Наименование` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Наименование транспорта',
  `Грузоподъемность` float NOT NULL COMMENT 'Грузоподъемность транспорта'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Таблица данных о транспорте компании';

--
-- Дамп данных таблицы `транспорт`
--

INSERT INTO `транспорт` (`Id`, `Наименование`, `Грузоподъемность`) VALUES
(1, 'Volvo FN', 5),
(2, 'Volvo F90', 7),
(3, 'Газель Next', 2),
(4, 'MAN F2000', 10),
(5, 'MAN F90', 12),
(6, 'MAN TGL', 6),
(7, 'MAN F1000', 8),
(8, 'MAN F500', 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `login_password`
--
ALTER TABLE `login_password`
  ADD PRIMARY KEY (`Id(LP)`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD KEY `Id(Status)` (`Id`) USING BTREE;

--
-- Индексы таблицы `маршрут`
--
ALTER TABLE `маршрут`
  ADD UNIQUE KEY `Уникальный маршрут` (`Id`),
  ADD KEY `Id(Маршрута)` (`Id`);

--
-- Индексы таблицы `груз`
--
ALTER TABLE `груз`
  ADD UNIQUE KEY `Id(груз)` (`Id`),
  ADD KEY `Рейс` (`Рейс`);

--
-- Индексы таблицы `рейс`
--
ALTER TABLE `рейс`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Id(Рейс)` (`Id`),
  ADD KEY `Маршрут` (`Маршрут`),
  ADD KEY `Транспорт` (`Транспорт`),
  ADD KEY `Статус` (`Статус`);

--
-- Индексы таблицы `транспорт`
--
ALTER TABLE `транспорт`
  ADD UNIQUE KEY `Id(Транспорта)` (`Id`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `login_password`
--
ALTER TABLE `login_password`
  MODIFY `Id(LP)` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `груз`
--
ALTER TABLE `груз`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT COMMENT 'Уникальный Id отправленного груза', AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `груз`
--
ALTER TABLE `груз`
  ADD CONSTRAINT `груз_ibfk_1` FOREIGN KEY (`Рейс`) REFERENCES `рейс` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `рейс`
--
ALTER TABLE `рейс`
  ADD CONSTRAINT `рейс_ibfk_1` FOREIGN KEY (`Маршрут`) REFERENCES `маршрут` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `рейс_ibfk_2` FOREIGN KEY (`Транспорт`) REFERENCES `транспорт` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `рейс_ibfk_3` FOREIGN KEY (`Статус`) REFERENCES `status` (`Id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
