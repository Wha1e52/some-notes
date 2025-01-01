"""
get_nowait и put_nowait.
Зачем этот суффикс nowait? Есть два способа поместить элемент
в очередь и выбрать его оттуда: неблокирующий и регулярный. Вари-
анты get_nowait и put_nowait не блокируют выполнения и возвраща-
ют управление немедленно.

Сопрограмма get блокирует выполнение (не прибегая к активно-
му ожиданию), пока в очереди не появится элемент, и не возбуждает
исключения. Это эквивалентно простаиванию задач-исполнителей,
которые ждут, когда в очереди появится покупатель, нуждающийся
в обслуживании.

Метод-сопрограмма put блокирует выполнение, пока в очереди не освободится место.

Метод queue.task_done сигнализирует очереди, что исполнитель завер-
шил обработку текущего элемента данных. Под капотом класс Queue
хранит счетчик, который увеличивается на единицу при выборке эле-
мента из очереди; так очередь следит за количеством незавершенных
задач. Вызов метода task_done говорит очереди, что задача заверши-
лась, поэтому счетчик уменьшается на единицу.


"""


import asyncio
from asyncio import Queue
from random import randrange
from typing import List
from collections import defaultdict


class Product:
    def __init__(self, name: str, checkout_time: float, price: float):
        self.name = name
        self.checkout_time = checkout_time
        self.price = price


class Customer:
    def __init__(self, customer_id: int, products: list[Product]):
        self.customer_id = customer_id
        self.products = products


async def checkout_customer(queue: Queue, cashier_number: int):
    all_sum = 0
    while True:
        customer: Customer = await queue.get()
        print(f'Кассир {cashier_number} '
              f'обслуживает покупателя '
              f'{customer.customer_id}')

        check_list = {'sum': 0, 'items': {}}
        for product in customer.products:
            print(f"Кассир {cashier_number} "
                  f"обслуживает покупателя "
                  f"{customer.customer_id}: {product.name}")
            await asyncio.sleep(product.checkout_time)
            check_list['items'].setdefault(product.name, {'price': 0, 'count': 0, 'product_price': product.price})
            check_list['items'][product.name]['price'] += product.price
            check_list['items'][product.name]['count'] += 1
            check_list['sum'] += product.price

        print(f'Кассир {cashier_number} '
              f'закончил обслуживать покупателя '
              f'{customer.customer_id}, потраченная сумма: {check_list}')
        all_sum += check_list['sum']
        queue.task_done()
    return all_sum


def generate_customer(customer_id: int) -> Customer:
    all_products = [Product('пиво', 2, 50.0),
                    Product('бананы', .5, 20.0),
                    Product('колбаса', .2, 134.0),
                    Product('подгузники', .2, 150.0)]
    products = [all_products[randrange(len(all_products))] for _ in range(randrange(10))]
    return Customer(customer_id, products)


async def customer_generator(queue: Queue):
    customer_count = 0
    while True:
        customers = [generate_customer(i) for i in range(customer_count, customer_count + randrange(5))]
        for customer in customers:
            print('Ожидаю возможности поставить покупателя в очередь...')
            await queue.put(customer)
            print('Покупатель поставлен в очередь!')
        customer_count = customer_count + len(customers)
        await asyncio.sleep(1)


async def main():
    customer_queue = Queue(5)
    customer_producer = asyncio.create_task(customer_generator(customer_queue))
    cashiers = [asyncio.create_task(checkout_customer(customer_queue, i)) for i in range(3)]
    await asyncio.gather(customer_producer, *cashiers)

asyncio.run(main())













