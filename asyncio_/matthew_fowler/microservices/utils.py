import asyncio
import json
import logging
from typing import Callable, Awaitable

class TooManyRetries(Exception):
    pass


async def retry(coro: Callable[[], Awaitable], max_retries: int, timeout: float, retry_interval: float):
    for retry_num in range(1, max_retries + 1):
        try:
            return await asyncio.wait_for(coro(), timeout=timeout)
        except Exception as e:
            logging.exception(f'Во время ожидания произошло исключение (попытка {retry_num})), пробую еще раз.',
                              exc_info=e)
            await asyncio.sleep(retry_interval)
    raise TooManyRetries()


async def main():
    async def always_fail():
        raise Exception("А я грохнулась!")

    async def always_timeout():
        await asyncio.sleep(1)

    try:
        await retry(always_fail, max_retries=3, timeout=.1, retry_interval=.1)
    except TooManyRetries:
        print('Слишком много попыток!')

    try:
        await retry(always_timeout, max_retries=3, timeout=.1, retry_interval=.1)
    except TooManyRetries:
        print('Слишком много попыток!')


import asyncio
from datetime import datetime, timedelta


class CircuitOpenException(Exception):
    pass


class CircuitBreaker:
    def __init__(self, callback, timeout: float, time_window: float, max_failures: int, reset_interval: float):
        self.callback = callback
        self.timeout = timeout
        self.time_window = time_window
        self.max_failures = max_failures
        self.reset_interval = reset_interval
        self.last_request_time = None
        self.last_failure_time = None
        self.current_failures = 0

    async def request(self, *args, **kwargs):
        if self.current_failures >= self.max_failures:
            if datetime.now() > self.last_request_time + timedelta(seconds=self.reset_interval):
                self._reset('Цепь переходит из разомкнутого состояния в замкнутое, сброс!')
                return await self._do_request(*args, **kwargs)
            else:
                print('Цепь разомкнута, быстрый отказ!')
                raise CircuitOpenException()
        else:
            if self.last_failure_time and datetime.now() > self.last_failure_time + timedelta(seconds=self.time_window):
                self._reset('Interval since first failure elapsed, resetting!')
            print('Цепь замкнута, отправляю запрос!')
            return await self._do_request(*args, **kwargs)

    def _reset(self, msg: str):
        print(msg)
        self.last_failure_time = None
        self.current_failures = 0

    async def _do_request(self, *args, **kwargs):
        try:
            print('Отправляется запрос!')
            self.last_request_time = datetime.now()
            return await asyncio.wait_for(self.callback(*args, **kwargs), timeout=self.timeout)
        except Exception as e:
            self.current_failures = self.current_failures + 1
            if self.last_failure_time is None:
                self.last_failure_time = datetime.now()
            raise




async def main2():
    async def slow_callback():
        await asyncio.sleep(2)

    cb = CircuitBreaker(slow_callback, timeout=1.0, time_window=5, max_failures=2, reset_interval=5)
    for _ in range(4):
        try:
            await cb.request()
        except Exception as e:
            pass

    print('Засыпаю на 5 с, чтобы прерыватель замкнулся...')
    await asyncio.sleep(5)

    for _ in range(4):
        try:
            await cb.request()
        except Exception as e:
            pass



