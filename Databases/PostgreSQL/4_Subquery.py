'''

SELECT company_name
FROM suppliers
WHERE country IN (SELECT DISTINCT country FROM customers)
_______________________________________________________________________________________________________________________

WHERE (NOT) EXIST                   # вернет true, если в подзапросе возвращена хотя бы 1 строка

SELECT company_name, contact_name
FROM customers
WHERE EXIST (SELECT customer_id FROM orders
             WHERE customer_id = customers.customer_id
             AND freight BETWEEN 50 AND 100)












'''