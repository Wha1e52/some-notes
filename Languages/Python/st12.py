import copy
import logging
import os.path
import threading
import time
from abc import ABC, abstractmethod
from functools import wraps
from pprint import pprint
from random import randint
import asyncio
from asyncio.events import AbstractEventLoop
from concurrent.futures import ProcessPoolExecutor
from functools import partial
from typing import List
import requests

# def api():
#     url = "https://api.opensubtitles.com/api/v1/subtitles"
#
#     headers = {
#         "User-Agent": "testspaw v1.2.3",
#         "Api-Key": "eBndKccHY0z1F0ynuZtqr3Hi40di2qZ0",
#         "Content-Type": "application/json",
#     }
#     params = {
#         "query": "Harry Potter and the Philosopher's Stone",
#         'languages': 'en',
#         'order_by': 'upload_date',
#     }
#     response = requests.get(url, headers=headers, params=params)
#
#     # data = response.json()['data']
#     # for i in data:
#     #     aa = i['attributes']['release']
#     #     print(aa)
#
#     pprint(response.json())
if __name__ == '__main__':
    pass