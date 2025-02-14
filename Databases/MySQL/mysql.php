<?php

/*
Урок 2.Создание БД и таблиц

атрибут
UNSIGNED не подразумевает хранить отрицательные числа(-128 до 127) будет (0 до 255)

Урок 3.Первые запросы SQL

USE database_name; выбрать базу для работы

CREATE DATABASE IF NOT EXISTS `database_name`; создать базу данных

CREATE TABLE `table_name` (
    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(20),
    `age` TINYINT UNSIGNED
); создать таблицу

RENAME TABLE table_name TO new_table_name; переименовать таблицу

TRUNCATE TABLE table_name; очистить все данные в таблице

DROP TABLE table_name; удалить таблицу

DROP DATABASE IF EXISTS `database_name`; удалить базу данных

Урок 4.Типы данных. Часть 1

тип данных
DECIMAL(7,2) использовать для точности (сколько всего знаков, знаки после запятой)

Урок 5.Типы данных. Часть 2

тип данных
CHAR фиксированная длинна (всегда выделено заданное число байт)
VARCHAR строка занимает свою длину (по памяти + 1 байт на длину строки)

DATETIME полная дата и время "year-month-day h:m:s" занимает 8 байт
TIMESTAMP полная дата и время но хранит иначе (интервал с 1970 до 2038) занимает 4 байта
ENUM список значений, если значения нет в списке будет пустая строка

Урок 7.Простой запрос SELECT

SELECT список_столбцов FROM имя_таблицы;
можно использовать обратные кавычки(ё) для обрамления названия таблицы

SELECT * FROM имя_таблицы; получить все данные

Урок 8.Ограничение выборки SELECT

SELECT DISTINCT список_столбцов FROM имя_таблицы; выборка уникальных значений

SELECT список_столбцов FROM имя_таблицы LIMIT n; где n - кол-во строк

SELECT список_столбцов FROM имя_таблицы LIMIT n OFFSET x; сделать отступ в x записей
SELECT список_столбцов FROM имя_таблицы LIMIT n,x; более краткая версия

Урок 9.Сортировка данных с ORDER BY

SELECT список_столбцов FROM имя_таблицы ORDER BY список_столбцов;
SELECT столбец1, столбец2 FROM имя_таблицы ORDER BY 1, 2; (1, 2 - номера полей при перечислении)

SELECT список_столбцов FROM имя_таблицы ORDER BY список_столбцов ASC; по возрастанию (по умолчанию)
SELECT список_столбцов FROM имя_таблицы ORDER BY список_столбцов DESC; по убыванию
SELECT столбец1, столбец2 FROM имя_таблицы ORDER BY столбец1 DESC, столбец2 DESC; можно указывать для каждого

Урок 10.Фильтрация данных. Часть 1

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 > 1000; условия выборки
SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 != 'some_name';

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 BETWEEN 10 AND 20; диапазон

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 IS NOT NULL;

Урок 11.Фильтрация данных. Часть 2

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 IS NOT NULL AND столбец2 >= 10;
при большем кол-ве условий используем круглые скобки для указания приоритета

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 IN ('some_str1', 'some_str2');

Урок 12.Оператор LIKE

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 LIKE 'some_str%'
% - ноль или больше любых символов
_ - один символ

Урок 13.Вычисляемые поля и псевдонимы в MySQL

SELECT CONCAT(столбец1, ', ', столбец2) FROM имя_таблицы; конкатенация в единую строку

алиасы(можно использовать в GROUP BY, HAVING, ORDER BY)
SELECT CONCAT(столбец1, ', ', столбец2) AS alias_name FROM имя_таблицы;
SELECT столбец1 c1, столбец2 c2 FROM имя_таблицы; можно и без AS

SELECT столбец1, (столбец2 / столбец3) AS some_column_name FROM имя_таблицы;

Урок 14.Функции MySQL

SELECT CONCAT_WS(', ', столбец1, столбец2) AS alias_name FROM имя_таблицы; первым параметром идет разделитель(with separator)

SELECT FORMAT(num1, num2, ['local']); num2 - сколько знаков после запятой, локаль по-умолчанию en_US

строковые
SELECT LOWER(столбец1), столбец2 FROM имя_таблицы; lowercase
SELECT UPPER(столбец1), столбец2 FROM имя_таблицы; uppercase
SELECT TRIM(столбец1), столбец2 FROM имя_таблицы; обрезка пробельных символов с краев, есть еще LTRIM/RTRIM

числовые
CEIL огругление к большему
FLOOR огругление к меньшему(отбрасывается дробная часть)
ROUND(num1, [num2]) огругление по математике. num2 - сколько знаков после запятой

дата и время
SET lc_time_names = 'ru_RU'; поменять локаль на ру
NOW()
DATE_FORMAT(some_date, 'formater') '%d-%m-%Y'

Урок 15.Агрегатные функции MySQL

SELECT COUNT(*) FROM имя_таблицы; счетчик.  пропукает null если передаем явное поле.
SELECT SUM(столбец1) FROM имя_таблицы; сумма всех значений в столбце
SELECT MAX(столбец1) FROM имя_таблицы; макс значение в столбце
SELECT MIN(столбец1) FROM имя_таблицы; мин значение в столбце
SELECT AVG(столбец1) FROM имя_таблицы; высчитывает среднее значение по столбцу

Урок 16.Группировка данных в MySQL

SELECT id, SUM(столбец1), столбец2 FROM имя_таблицы GROUP BY столбец2; группировка
SELECT id, SUM(столбец1), столбец2 FROM имя_таблицы GROUP BY столбец2 HAVING id > 5; HAVING тоже что и WHERE только работает с GROUP BY

Урок 17.Подзапросы в MySQL

SELECT столбец1, столбец2 FROM имя_таблицы WHERE столбец1 IN (SELECT столбец3, столбец4 FROM имя_таблицы2 WHERE столбец4 = 2);

Урок 18.Объединение таблиц в MySQL

SELECT city.name, (SELECT country.name FROM country WHERE country.code = city.coutyrycode) AS country FROM city;
SELECT city.name, country.name AS country FROM city, country WHERE country.code = city.coutyrycode;

Урок 19.Объединение таблиц в MySQL. JOIN. Часть 1

INNER JOIN извлекает только строки где есть значение во всех таблицах
SELECT city.name, country.name AS country FROM city, [INNER] JOIN country ON country.code = city.coutyrycode;

Урок 20.Объединение таблиц в MySQL. JOIN. Часть 2

LEFT [OUTER] JOIN извлекает все данные из левой таблицы, в правой если нет соответствия проставит null
SELECT city.name, country.name AS country FROM city, LEFT [OUTER] JOIN country ON country.code = city.coutyrycode;

Урок 21.Объединение запросов в MySQL. Оператор UNION

кол-во столбцов должно совпадать в обоих таблицах
типы столбцов должны быть совместимы

SELECT firstname, lastname FROM clients
UNION (отбрасывает дублирующие записи)
SELECT firstname, lastname FROM employees;


SELECT firstname, lastname FROM clients
UNION ALL (с дублями)
SELECT firstname, lastname FROM employees;

Урок 22.Оператор INSERT в MySQL

INSERT [INTO] имя_таблицы [(столбец1, столбец2, ...)] VALUES (значение1, значение2, ...)

INSERT INTO products (name, manufacturer, price) VALUES ('str1', 'str2', 10), ('str3', 'str4', 20);

вставка из селекта
INSERT INTO products2 (id, name, manufacturer, price) SELECT id, name, manufacturer, price FROM products;

создание таблицы на лету, проставка индексов и заполнение из селекта
CREATE TABLE products_copy (id INT AUTO_INCREMENT PRIMARY KEY) AS SELECT * FROM products;

скопировать только структуру таблицы
CREATE TABLE products_copy LIKE products;

Урок 23.Операторы UPDATE и DELETE

UPDATE products_copy SET manufacturer = 'some_str', price = NULL WHERE id = 9;

DELETE FROM products_copy WHERE id = 3;

TRUNCATE TABLE products_copy; полная очистка таблицы

Урок 24.Создание, изменение и удаление таблиц в MySQL

CREATE TABLE [IF NOT EXISTS] Products_copy
(
	Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ProductName VARCHAR(30) NOT NULL,
	Manufacturer VARCHAR(20) NOT NULL,
	ProductCount INT NULL DEFAULT '0',
	Price DECIMAL(10,0) NOT NULL DEFAULT '0'
);

ALTER TABLE Products_copy MODIFY Manufacturer VARCHAR(255);

ALTER TABLE Products_copy ADD test INT;

ALTER TABLE Products_copy DROP COLUMN test;

DROP TABLE Products_copy;

Урок 25.Представления в MySQL

CREATE VIEW city_info AS
	SELECT city.Name AS city_name, country.Name AS country_name, country.Code, countrylanguage.Language
	    FROM country
	     JOIN city ON city.CountryCode = country.Code
	     JOIN countrylanguage ON countrylanguage.CountryCode = country.Code
	     WHERE countrylanguage.IsOfficial = 'T';


SELECT * FROM city_info;

DROP VIEW IF EXISTS city_info;

Урок 26.Хранимые процедуры в MySQL

DELIMITER //
CREATE PROCEDURE city_info(l INT)
BEGIN
    SELECT city.Name AS city_name, country.Name AS country_name, country.Code, countrylanguage.Language
    FROM country
     JOIN city ON city.CountryCode = country.Code
     JOIN countrylanguage ON countrylanguage.CountryCode = country.Code
     WHERE countrylanguage.IsOfficial = 'T' LIMIT l;
END //


CALL city_info(5)
*/


// комментарии:

#однострочный

// -- однострочный(один пробел после --)

/*
многострочный
комментарий
*/