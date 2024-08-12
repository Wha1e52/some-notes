'''

INNER JOIN                # в результате будут только те строки, где ключу есть соответствие в другой таблице
LEFT OUTER JOIN           # все строки из левой таблицы, но если нет соответствия по ключу вставляется NULL
RIGHT OUTER JOIN          # так же как и с LEFT JOIN только из правой таблицы. (поэтому можно использовать LEFT JOIN просто поменяв таблицы местами)
FULL OUTER JOIN           # LEFT JOIN + RIGHT JOIN(все данные из обеих таблиц, если нет соответствия по ключу вставляется NULL)
CROSS JOIN                # каждой записи из левой таблицы будут соответствовать все записи из правой таблицы
SELF JOIN                 # любой из JOIN просто на ту же таблицу
_______________________________________________________________________________________________________________________

SELECT product_name, suppliers.company_name, units_in_stock
FROM products
INNER JOIN suppliers ON products.supplier_id = suppliers.supplier_id        # соединяем 2 таблицы по ключам supplier_id
ORDER BY units_in_stock DESC

SELECT category_name, SUM(unit_price * units_in_stock)
FROM products
INNER JOIN categories ON products.category_id = categories.category_id
WHERE discontinued =! 1
GROUP BY category_name
HAVING SUM(unit_price * units_in_stock) > 5000
ORDER BY SUM(unit_price * units_in_stock) DESC

SELECT contact_name, company_name, phone, first_name, last_name, title, order_date, product_name, ship_country, products.unit_price, quantity, discount
FROM orders
JOIN order_details ON orders.order_id = order_details.order_id                   # JOIN = INNER JOIN
INNER JOIN products ON order_details.product_id = products.product_id
JOIN customers ON orders.customer_id = customers.customer_id
JOIN employees ON orders.employee_id = employees.employee_id
WHERE ship_country = 'USA

                 ||

SELECT contact_name, company_name, phone, first_name, last_name, title, order_date, product_name, ship_country, products.unit_price, quantity, discount
FROM orders
JOIN order_details USING(order_id)          # USING - синтаксический сахар
JOIN products USING(product_id)             # = ON order_details.product_id = products.product_id
JOIN customers USING(customer_id)
JOIN employees USING(employee_id)
WHERE ship_country = 'USA






































'''
