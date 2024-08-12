'''

CASE

SELECT order_id, order_date,            # запятая в конце обязательна
	CASE
		WHEN date_part('month', order_date) BETWEEN 3 AND 5 THEN 'spring'
		WHEN date_part('month', order_date) BETWEEN 6 AND 8 THEN 'summer'
		WHEN date_part('month', order_date) BETWEEN 9 AND 11 THEN 'autumn'
		ELSE 'winter'
	END AS season
FROM orders

_______________________________________________________________________________________________________________________

COALESCE(arg1, arg2, ...)               # вернет arg1 если он не NULL, а если он NULL, то вернет arg2

SELECT order_id, order_date, COALESCE(ship_region, 'unknown') AS ship_region
FROM orders
LIMIT 10
_______________________________________________________________________________________________________________________

NULLIF(arg1, arg2)              # если arg1 = arg2 вернет NULL, иначе вернет arg1

SELECT contact_name, COALESCE(NULLIF(city, ''), 'unknown') AS city
FROM customers


'''