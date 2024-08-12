'''

CREATE OR REPLACE FUNCTION get_max_price_from_discontinued() RETURNS real AS $$
BEGIN
    RETURN MAX(unit_price)
    FROM products
    WHERE discontinued = 1;             # ; - в конце обязательна
END;                                    # ; - в конце обязательна
$$ LANGUAGE plpgsql;

SELECT get_max_price_from_discontinued();
_____________

CREATE OR REPLACE FUNCTION get_price_boundaries(OUT max_price real, OUT min_price real) AS $$
BEGIN
    SELECT MAX(unit_price), MIN(unit_price)
    INTO max_price, min_price
    FROM products;                       # ; - в конце обязательна
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_price_boundaries();

______________

CREATE OR REPLACE FUNCTION get_customers_by_country(customer_country varchar) RETURNS SETOF customers AS $$
BEGIN
    RETURN QUERY
    SELECT *
    FROM customers
    WHERE country = customer_country;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_customers_by_country('USA')

______________

CREATE OR REPLACE FUNCTION get_sum(x int, y int, out result int) AS $$
BEGIN
    result := x + y;                        # := - оператор присвоения, можно и без :
    RETURN;                                 # досрочно завершает функцию
END;
$$ LANGUAGE plpgsql;

SELECT * FROM get_sum(2, 3)

______________

DECLARE

CREATE FUNCTION calc_middle_price() RETURNS SETOF products AS $$
DECLARE                                      # объявляем переменные
    avg_price real;
    low_price real;
    high_price real;
BEGIN
    SELECT AVG(unit_price) INTO avg_price FROM products;
    low_price := avg_price * 0.75;
    high_price := avg_price * 1.25;

    RETURN QUERY
    SELECT * FROM products
    WHERE unit_price BETWEEN low_price AND high_price;
END;
$$ LANGUAGE plpgsql;

SELECT * FROM calc_middle_price()
_______________________________________________________________________________________________________________________

IF ELSEIF ELSE

CREATE OR REPLACE FUNCTION get_season(month_number int) RETURNS text AS $$
DECLARE season text;
BEGIN

    IF month_number > 12 THEN
        RAISE EXCEPTION 'month_number must not exceed 12. month number is %', month_number;      # понимаем исключение
    END IF;

	IF month_number BETWEEN 3 AND 5 THEN
		season := 'Spring';
	ELSEIF month_number BETWEEN 6 AND 8 THEN
		season := 'Summer';
	ELSEIF month_number BETWEEN 9 AND 11 THEN
		season := 'Autumn';
	ELSE
		season := 'Winter';
	END IF;

	RETURN season;
END;
$$ LANGUAGE plpgsql;

SELECT get_season(2);
_______________________________________________________________________________________________________________________

циклы

WHILE expression
LOOP
    logic
END LOOP;

LOOP
    EXIT WHEN counter > n
    logic
END LOOP;


DO $$                                              # просто анонимный кусок кода
BEGIN
    FOR counter IN 1..5 BY 2
    LOOP
        RAISE NOTICE 'Counter: %', counter;
    END LOOP;
END$$;

* CONTINUE WHEN expression
_______________________________________________________________________________________________________________________







'''