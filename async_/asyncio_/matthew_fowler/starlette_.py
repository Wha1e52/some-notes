import asyncpg
from asyncpg import Record
from asyncpg.pool import Pool
from starlette.requests import Request
from starlette.responses import JSONResponse, Response
from starlette.templating import Jinja2Templates
from starlette.routing import Route
import asyncio
from starlette.applications import Starlette
from starlette.endpoints import WebSocketEndpoint
from starlette.routing import WebSocketRoute
templates = Jinja2Templates("./")


async def create_database_pool():
    pool: Pool = await asyncpg.create_pool(
        host="127.0.0.1",
        port=5432,
        user="postgres",
        password="password",
        database="products",
        min_size=6,
        max_size=6,
    )

    app.state.DB = pool


async def destroy_database_pool():
    pool = app.state.DB
    await pool.close()


async def brands(request: Request) -> Response:
    connection: Pool = request.app.state.DB
    brand_query = "SELECT brand_id, brand_name FROM brand"
    results: list[Record] = await connection.fetch(brand_query)
    result_as_dict: list[dict] = [dict(brand) for brand in results]
    return JSONResponse(result_as_dict)


async def test(request: Request) -> Response:
    return templates.TemplateResponse("test.html", {"request": request})


# при нескольких процессах нужно использовать базу данных т.к у каждого свой список
class UserCounter(WebSocketEndpoint):
    encoding = "text"
    sockets = []

    async def on_connect(self, websocket):
        await websocket.accept()
        UserCounter.sockets.append(websocket)
        await self._send_count()

    async def on_disconnect(self, websocket, close_code):
        UserCounter.sockets.remove(websocket)
        await self._send_count()

    async def on_receive(self, websocket, data):
        pass

    async def _send_count(self):
        if len(UserCounter.sockets) > 0:
            count_str = str(len(UserCounter.sockets))
            task_to_socket = {
                asyncio.create_task(websocket.send_text(count_str)): websocket
                for websocket in UserCounter.sockets
            }
            done, pending = await asyncio.wait(task_to_socket)

            for task in done:
                if task.exception() is not None:
                    if task_to_socket[task] in UserCounter.sockets:
                        UserCounter.sockets.remove(task_to_socket[task])


app = Starlette(routes=[WebSocketRoute("/counter", UserCounter),
                        Route("/", test)],
                on_startup=[create_database_pool],
                on_shutdown=[destroy_database_pool])
