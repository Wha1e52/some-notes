"""
Для хранения разделяемых данных класс aiohttp Application может
выступать в роли словаря. Например, если бы мы хотели завести раз-
деляемый словарь, к которому имеют доступ все маршруты, то могли
бы сохранить его в приложении следующим образом:
app = web.Application()
app['shared_dict'] = {'key' : 'value'}

Приложение aiohttp предоставляет обработчик сигнала on_startup,
который можно использовать для инициализации. Можете считать,
что это список сопрограмм, выполняемых при запуске приложе-
ния. Для добавления сопрограммы нужно написать app.on_startup.append(coroutine).
Любой добавленной таким образом сопрограмме передается один параметр: экземпляр класса Application.

aiohttp предоставляет еще один обработчик сигнала, on_cleanup. Зарегистрированные в нем
сопрограммы будут вызываться при закрытии приложения, так что
именно там проще всего остановить пул подключений. Для добавле-
ния сопрограмм тоже используется метод append.

Как создать
маршрут с параметром? Библиотека aiohttp для этой цели предлагает
заключать параметры в фигурные скобки, т. е. маршрут будет иметь
вид /products/{id}. Соответствующие параметрам значения мы най-
дем в словаре match_info, хранящемся в запросе. В данном случае за-
данное пользователем значение параметра id можно будет получить
в виде строки, написав request.match_info['id'].

В мире веб-приложений aiohttp отличается тем, что сама она является веб-сервером и, не отвечая
требованиям к WSGI, может работать автономно.
"""
import asyncpg
from aiohttp import web
from aiohttp.web_app import Application
from aiohttp.web_request import Request
from aiohttp.web_response import Response
from asyncpg import Record
from asyncpg.pool import Pool
from typing import List, Dict

routes = web.RouteTableDef()
DB_KEY = 'database'


@routes.post('/product')
async def create_product(request: Request) -> Response:
    PRODUCT_NAME = 'product_name'
    BRAND_ID = 'brand_id'
    if not request.can_read_body:
        raise web.HTTPBadRequest()
    body = await request.json()
    if PRODUCT_NAME in body and BRAND_ID in body:
        db = request.app[DB_KEY]
        await db.execute('''INSERT INTO product(product_id, product_name, brand_id) VALUES(DEFAULT, $1, $2)''',
                         body[PRODUCT_NAME],
                         int(body[BRAND_ID]))
        return web.Response(status=201)
    else:
        raise web.HTTPBadRequest()


@routes.get('/products/{id}')
async def get_product(request: Request) -> Response:
    try:
        str_id = request.match_info['id']
        product_id = int(str_id)
        query = """
        SELECT
            product_id,
            product_name,
            brand_id
        FROM product
        WHERE product_id = $1
        """
        connection: Pool = request.app[DB_KEY]
        result: Record = await connection.fetchrow(query, product_id)
        if result:
            return web.json_response(dict(result))
        else:
            raise web.HTTPNotFound()
    except ValueError:
        raise web.HTTPBadRequest()


async def create_database_pool(app: Application):
    print('Создается пул подключений.')
    pool: Pool = await asyncpg.create_pool(host='127.0.0.1',
                                           port=5432,
                                           user='postgres',
                                           password='password',
                                           database='products',
                                           min_size=6,
                                           max_size=6)
    app[DB_KEY] = pool


async def destroy_database_pool(app: Application):
    print('Уничтожается пул подключений.')
    pool: Pool = app[DB_KEY]
    await pool.close()


@routes.get('/brands')
async def brands(request: Request) -> Response:
    connection: Pool = request.app[DB_KEY]
    brand_query = 'SELECT brand_id, brand_name FROM brand'
    results: List[Record] = await connection.fetch(brand_query)
    result_as_dict: List[Dict] = [dict(brand) for brand in results]
    return web.json_response(result_as_dict)


app = web.Application()
app.on_startup.append(create_database_pool)
app.on_cleanup.append(destroy_database_pool)
app.add_routes(routes)

if __name__ == '__main__':
    web.run_app(app, port=8080, host='127.0.0.1')
