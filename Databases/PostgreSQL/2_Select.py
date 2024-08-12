'''

SELECT id, name, price                 # выбираем столбцы(колонки)
FROM products                          # из какой таблицы
_____________________________________________________________________

SELECT name, price * weight            # во 2й колонке будет результат перемножения значений 2х колонок
FROM products
_________________________________________________________________________

SELECT DISTINCT city                   # выводит только уникальные значения
FROM employees
__________________________________________________________________________

SELECT COUNT (DISTINCT city)           # выводит кол-во строк в колонках (с DISTINCT будут только уникальные значения)
FROM employees
________________________________________________________________________________

# != / <> - неравенство

SELECT name, contact, phone, country
FROM customers
WHERE country = 'USA';                  # условие для выборки (будут только те строки, где country = USA)

SELECT *
FROM products
WHERE price > 20;

SELECT COUNT(*)
FROM products
WHERE price > 20;
_________________________________________________________________________________________

SELECT *
FROM orders
WHERE date > '1998-3-12' AND (freight < 75 OR freight > 150)       # AND и OR для совмещения условий
_________________________________________________________________________________________

BETWEEN от и до включая границы

SELECT COUNT(*)
FROM orders
WHERE freight BETWEEN 20 AND 40                   # = WHERE freight >= 20 AND freight <= 40;
_________________________________________________________________________________________

SELECT name, contact, phone, country
FROM customers
WHERE country IN ('USA', 'Germany', 'Russia');    # = WHERE country = 'USA' OR country = 'Germany' OR country = 'Russia'

SELECT *
FROM orders
WHERE id NOT IN (1, 2, 3)
_________________________________________________________________________________________

ORDER BY - сортировка по

SELECT DISTINCT country
FROM customers
ORDER BY country;                                # упорядочивание по возрастанию (ASC по умолчанию)

SELECT DISTINCT country
FROM customers
ORDER BY country DESC;                            # DESC - по убыванию

SELECT DISTINCT country, city
FROM customers
ORDER BY country DESC, city ASC                  # сортировка по 2м колонкам, сначала первая, потом 2я относительно 1й

_________________________________________________________________________________________

MIN, MAX, SUM, AVG - высчитывает среднее значение

SELECT MIN(date)                                 # MIN - находит минимальное значение в колонке
FROM orders
WHERE city = 'London'
_________________________________________________________________________________________

CONCAT(first_name, ' ', last_name)               # преобразует в строку

_________________________________________________________________________________________

pattern matching with LIKE

placeholder % - 0 и более символов
placeholder _ - 1 любой символов

SELECT last_name, first_name
FROM employees
WHERE first_name LIKE '%n';                      # имя будет заканчиваться на n

SELECT last_name, first_name
FROM employees
WHERE first_name LIKE 'B%'                      # имя будет начинаться на B
_________________________________________________________________________________________

LIMIT

SELECT id, name, price
FROM products
LIMIT 5                                         # ограничивает вывод до n строк
_________________________________________________________________________________________

IS NULL, IS NOT NULL

SELECT city, region, country
FROM orders
WHERE region IS NOT NULL                       # где значения в колонке (не) являются NULL
_________________________________________________________________________________________

GROUP BY группировка по
AS псевдоним

SELECT id, SUM(stock) AS stock_sum             # называем колонку (нельзя использовать в where, т.к сначала FROM-WHERE-SELECT)
FROM products
GROUP BY id                                    # группируем по id
ORDER BY stock_sum DESC
LIMIT 5
_________________________________________________________________________________________

HAVING

SELECT id, SUM(stock * price)
FROM products
WHERE discontinued != 1
GROUP BY id
HAVING SUM(stock * price) > 5000           # вторичный фильтр(почти тоже самое что WHERE) только для рез-та группировки
ORDER BY SUM(stock * price) DESC
_________________________________________________________________________________________

UNION (ALL), INTERSECT (ALL), EXCEPT (ALL) - (ALL - с дубликатами)

SELECT country
FROM customers
UNION                           # объединение результатов запросов(без дубликатов)
SELECT country
FROM employees;

f

SELECT country
FROM customers
EXCEPT                        # исключение результатов 2й выборки из 1й(без дубликатов). страны из customers, которые не пересекаются с employees
SELECT country
FROM employees;
_________________________________________________________________________________________

CAST('3' AS int)  =  '3'::int           # приведение типов













'''