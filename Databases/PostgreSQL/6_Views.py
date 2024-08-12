'''

CREATE (OR REPLACE) VIEW view_name AS
SELECT select_statement

ALTER VIEW old_view_name RENAME TO new_view_name

DROP VIEW (IF EXISTS) old_view_name



CREATE OR REPLACE VIEW view_name AS
SELECT select_statement
FROM some_table
WHERE some_statement
WITH LOCAL\CASCADE CHECK OPTION                   # будет обращаться к WHERE some_statement при попытке вставке данных


'''