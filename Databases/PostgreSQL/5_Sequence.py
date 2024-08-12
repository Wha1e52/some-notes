'''

CREATE SEQUENCE seq1;
SELECT nextval('seq1');
SELECT currval('seq1');
SELECT lastval();

SELECT setval('seq2', 15, true)             # с true currval будет = 15 (из setval)
SELECT currval('seq1'); #15
SELECT nextval('seq1'); #16

SELECT setval('seq2', 15, false)
SELECT currval('seq2');                     # будет храниться старое значение
SELECT nextval('seq2'); #15 (из setval)

CREATE SEQUENCE IF NOT EXISTS seq3
INCREMENT 10
MINVALUE 0
MAXVALUE 100
START WITH 0;
_______________________________________________________________________________________________________________________

serial

||

DROP TABLE IF EXISTS test;
CREATE TABLE test
(
    test_id int,
	test_name text,
	CONSTRAINT PK_test_test_id PRIMARY KEY(test_id)
);

CREATE SEQUENCE IF NOT EXISTS test_test_id_seq
START WITH 1 OWNED BY test.test_id;

ALTER TABLE test
ALTER COLUMN test_id SET DEFAULT nextval('test_test_id_seq');

_______________________________________________________________________________________________________________________

DROP TABLE IF EXISTS test;
CREATE TABLE test
(
    test_id int GENERATED ALWAYS AS IDENTITY(START WITH 10 INCREMENT BY 10),               # использовать вместо serial
	test_name text,
	CONSTRAINT PK_test_test_id PRIMARY KEY(test_id)
);




'''