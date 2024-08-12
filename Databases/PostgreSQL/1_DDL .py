'''

CREATE TABLE table_name
ALTER TABLE table_name
    ADD COLUMN column_name data_type
    RENAME TO new_table_name
    RENAME old_column_name TO new_column_name
    ALTER COLUMN column_name SET DATA TYPE data_type
DROP table_name
TRUNCATE TABLE table_name (RESTART IDENTITY)                # удаляет все данные в таблице и(сбрасывает счетчик serial)
DROP COLUMN column_name
____________________________________________________________________________________________________________

чтобы получить constraint:

SELECT constraint_name
FROM information_schema.key_column_usage
WHERE table_name = 'your_table_name'
AND table_schema = 'public'
AND column_name = 'your_column_name'

ALTER TABLE your_table_name
DROP CONSTRAINT constraint_name

ALTER TABLE your_table_name
ADD PRIMARY KEY (your_column_name)

____________________________________________________________________________________________________________

CHECK - логическое условие налагаемое на столбец
DEFAULT - что будет вставляться по умолчанию, если не предоставили данных

CREATE TABLE person
(
    person_id integer PRIMARY KEY,
    first_name varchar(64) NOT NULL,
    last_name varchar(64) NOT NULL,
    age int NOT NULL,
    status char DEFAULT 'r',
    CONSTRAINT CHK_person_age CHECK (age >= 18),
    CONSTRAINT CHK_person_status CHECK (status = 'r' or status = 'p')
);

ALTER TABLE person
ALTER COLUMN status DROP DEFAULT

ALTER TABLE person
ALTER COLUMN status SET DEFAULT 'r'

____________________________________________________________________________________________________________

INSERT

SELECT *
INTO new_table_that_not_exist
FROM customers
WHERE rating > 5

INSERT INTO table_that_exist
SELECT *
FROM customers
WHERE rating < 5

____________________________________________________________________________________________________________

UPDATE, DELETE
RETURNING

UPDATE author
SET full_name = 'Elias', rating = 5
WHERE author_id = 1

DELETE FROM author
WHERE rating < 4.5
RETURNING *                         # выведет результат запроса (как я понял, обычный принт)

DELETE FROM author                  # удаляет все и оставляет логи
TRUNCATE TABLE author               # удаляет все и не оставляет логи


____________________________________________________________________________________________________________





CREATE DATABASE somedb    # создает базу данных
________________________________________________

DROP DATABASE somedb      # удаляет базу данных
________________________________________________

CREATE TABLE publisher    # создает таблицу
(
    publisher_id integer PRIMARY KEY,
    org_name varchar(128) NOT NULL,
    address text NOT NULL,
);

CREATE TABLE book
(
    book_id integer NOT NULL,
    title text NOT NULL,
    isbn varchar(32) NOT NULL,
    CONSTRAINT pk_book_id PRIMARY KEY (book_id)          # PRIMARY KEY может состоять более чем из 1 колонки
);
________________________________________________
CREATE TABLE person    # создает таблицу
(
    person_id integer PRIMARY KEY,
    first_name varchar(64) NOT NULL,
    last_name varchar(64) NOT NULL,
);

CREATE TABLE passport    # создает таблицу
(
    passport_id integer PRIMARY KEY,
    serial_number int NOT NULL,
    fk_passport_person int REFERENCES person(person_id),            # создаем FOREIGN KEY
);
__________________________________________________

DROP TABLE publisher     # удаляет таблицу
DROP TABLE book
___________________________________________________________________________

INSERT INTO book         # вставляем данные в таблицу
VALUES
(1, 'The Diary of a Young Girl', '0199535566'),
(2, 'Pride and Alex''s milk', '23131231');           # одна ковычка экранирует другую Alex''s
____________________________________________________________________________

ALTER TABLE book                                   # изменяем таблицу
ADD COLUMN fk_publisher_id;                        # добавляем колонку(столбец)

ALTER TABLE book
ADD CONSTRAINT fk_book_publisher FOREIGN KEY (fk_publisher_id) REFERENCES publisher(publisher_id)












































'''