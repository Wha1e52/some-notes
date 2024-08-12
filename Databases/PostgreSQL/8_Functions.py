'''

CREATE (OR REPLACE) FUNCTION fix_region() RETURNS void AS $$
    UPDATE customers
    SET region = 'unknown'
    WHERE region IS NULL
$$ language PostgreSQL;

SELECT fix_region();


CREATE (OR REPLACE) FUNCTION get_total_number_of_goods() RETURNS bigint AS $$
    SELECT SUM(unit_in_stock)
    FROM products
$$ LANGUAGE PostgreSQL;

SELECT get_total_number_of_goods() AS total_goods;

_______________________________________________________________________________________________________________________

IN, OUT
DEFAULT

CREATE (OR REPLACE) FUNCTION get_price_boundaries_by_discontinuity(IN is_discontinued int DEFAULT 1, OUT max_price real,
OUT min_price real) AS $$
    SELECT MAX(unit_price), MIN(unit_price)
    FROM products
    WHERE discontinued = is_discontinued
$$ LANGUAGE PostgreSQL;

SELECT * FROM get_price_boundaries_by_discontinuity(1)
_______________________________________________________________________________________________________________________

RETURNS SETOF                   # возврат множества строк

CREATE OR REPLACE FUNCTION get_avg_prices_by_category() RETURNS SETOF double precision AS $$
    SELECT AVG(unit_price)
    FROM products
    GROUP BY category_id
$$ LANGUAGE PostgreSQL;

SELECT * FROM get_avg_prices_by_category() as avg_prices;

__________

RETURNS SETOF RECORD

CREATE OR REPLACE FUNCTION get_sum_avg_prices_by_category(OUT sum_price real, OUT avg_price float8) RETURNS SETOF RECORD AS $$
    SELECT SUM(unit_price), AVG(unit_price)
    FROM products
    GROUP BY category_id
$$ LANGUAGE PostgreSQL;

SELECT sum_price FROM get_sum_avg_prices_by_category();
SELECT sum_price, avg_price FROM get_sum_avg_prices_by_category();
SELECT * FROM get_sum_avg_prices_by_category();

________

RETURNS SETOF RECORD без OUT

CREATE OR REPLACE FUNCTION get_sum_avg_prices_by_category() RETURNS SETOF RECORD AS $$
    SELECT SUM(unit_price), AVG(unit_price)
    FROM products
    GROUP BY category_id
$$ LANGUAGE PostgreSQL;

SELECT * FROM get_sum_avg_prices_by_category() AS (sum_price real, avg_price float8);

_______________________________________________________________________________________________________________________

RETURNS TABLE

CREATE OR REPLACE FUNCTION get_customers_by_country(customer_country varchar) RETURNS TABLE(char_code char, company_name varchar) AS $$
    SELECT customer_id, company_name
    FROM customers
    WHERE country = customer_country
$$ LANGUAGE PostgreSQL;

SELECT * FROM get_customers_by_country('USA')

_______

RETURNS SETOF table_name

CREATE OR REPLACE FUNCTION get_customers_by_country(customer_country varchar) RETURNS SETOF customers AS $$
    SELECT *                                    # * - обязательна
    FROM customers
    WHERE country = customer_country
$$ LANGUAGE PostgreSQL;

SELECT * FROM get_customers_by_country('USA')









'''