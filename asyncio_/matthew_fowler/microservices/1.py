import asyncio
import functools
from asyncio import Task
import aiohttp
from aiohttp import web, ClientSession
from aiohttp.web_request import Request
from aiohttp.web_response import Response
import logging
from typing import Dict, Set, Awaitable, Optional, List
from utils import retry, CircuitBreaker

routes = web.RouteTableDef()

PRODUCT_BASE = 'http://127.0.0.1:8000'
INVENTORY_BASE = 'http://127.0.0.1:8001'
FAVORITE_BASE = 'http://127.0.0.1:8002'
CART_BASE = 'http://127.0.0.1:8003'


@routes.get('/products/all')
async def all_products(request: Request) -> Response:
    async with aiohttp.ClientSession() as session:
        product_request = functools.partial(session.get, f'{PRODUCT_BASE}/products')
        favorite_request = functools.partial(session.get, f'{FAVORITE_BASE}/users/5/favorites')
        cart_request = functools.partial(session.get, f'{CART_BASE}/users/5/cart')
        products = asyncio.create_task(retry(product_request,
                                             max_retries=3,
                                             timeout=.1,
                                             retry_interval=.1))
        favorites = asyncio.create_task(retry(favorite_request,
                                              max_retries=3,
                                              timeout=.1,
                                              retry_interval=.1))
        cart = asyncio.create_task(retry(cart_request,
                                         max_retries=3,
                                         timeout=.1,
                                         retry_interval=.1))
        requests = [products, favorites, cart]
        done, pending = await asyncio.wait(requests, timeout=1.0)
        if products in pending:
            [request.cancel() for request in requests]
            return web.json_response({'error': 'Не удалось подключиться к сервису товаров.'}, status=504)
        elif products in done and products.exception() is not None:
            [request.cancel() for request in requests]
            logging.exception('Ошибка сервера при подключении к сервису товаров.', exc_info=products.exception())
            return web.json_response({'error': 'Ошибка сервера при подключении к сервису товаров.'}, status=500)
        else:
            product_response = await products.result().json()
            product_results: List[Dict] = await get_products_with_inventory(session, product_response)
            cart_item_count: Optional[int] = await get_response_item_count(cart, done, pending,
                                                                           'Error getting user cart.')
            favorite_item_count: Optional[int] = await get_response_item_count(favorites, done, pending,
                                                                               'Error getting user favorites.')
            return web.json_response(
                {'cart_items': cart_item_count, 'favorite_items': favorite_item_count, 'products': product_results})


async def get_products_with_inventory(session: ClientSession, product_response) -> List[Dict]:
    async def get_inventory(session: ClientSession, product_id: str):
        url = f"{INVENTORY_BASE}/products/{product_id}/inventory"
        return await session.get(url)

    inventory_circuit = CircuitBreaker(get_inventory, timeout=.9, time_window=5.0, max_failures=3, reset_interval=30)

    def create_product_record(product_id: int, inventory: Optional[int]) -> Dict:
        return {'product_id': product_id, 'inventory': inventory}

    inventory_tasks_to_product_id = {
        asyncio.create_task(inventory_circuit.request(session, product['product_id'])): product['product_id']
        for product in product_response
    }

    inventory_done, inventory_pending = await asyncio.wait(inventory_tasks_to_product_id.keys(), timeout=1.0)
    product_results = []
    for done_task in inventory_done:
        if done_task.exception() is None:
            product_id = inventory_tasks_to_product_id[done_task]
            inventory = await done_task.result().json()
            product_results.append(create_product_record(product_id, inventory['inventory']))
        else:
            product_id = inventory_tasks_to_product_id[done_task]
            product_results.append(create_product_record(product_id, None))
            logging.exception(f'Не удалось получить сведения о наличии товара {product_id}', exc_info=done_task.exception())

    for pending_task in inventory_pending:
        pending_task.cancel()
        product_id = inventory_tasks_to_product_id[pending_task]
        product_results.append(create_product_record(product_id, None))

    return product_results


async def get_response_item_count(task: Task, done: Set[Awaitable], pending: Set[Awaitable], error_msg: str) -> \
Optional[int]:
    if task in done and task.exception() is None:
        return len(await task.result().json())
    elif task in pending:
        task.cancel()
    else:
        logging.exception(error_msg, exc_info=task.exception())
    return None


app = web.Application()
app.add_routes(routes)
web.run_app(app, port=9000)
