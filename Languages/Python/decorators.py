"""A decorator is a directive placed just before a function definition; Python applies this directive to the function
before it runs, to alter how the function code behaves.

Декоратор в Python – это паттерн, который позволяет расширять функциональность существующей функции, не изменяя ее код.
"""
from functools import wraps


def dec_with_args(x=10):
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            print(f'before func')
            result = func(*args, **kwargs)
            print(f'after func')
            print(x)
            return result

        # @wraps(func) == :
        # wrapper.__doc__ = func.__doc__
        # wrapper.__name__ = func.__name__
        # wrapper.__module__ = func.__module__
        # wrapper.__qualname__ = func.__qualname__
        # wrapper.__annotations__ = func.__annotations__
        return wrapper

    return decorator


@dec_with_args(x=100)  # --> add_numbers = dec_with_args(x=100) -> decorator -> decorator(add_numbers) -> wrapper
def add_numbers(a, b):
    res = a + b
    print(res)
    return res


class MyDecorator:
    def __init__(self, function):
        self.function = function
        self.counter = 0

    def __call__(self, *args, **kwargs):
        print("Calling function")
        res = self.function(*args, **kwargs)
        self.counter += 1
        print(f"Called {self.counter} times")
        return res


@MyDecorator
def some_function():
    return 42


class DecoratorWithParam:
    def __init__(self, param):
        self.param = param

    def __call__(self, func):
        def wrapper(*args, **kwargs):
            print("Decorator parameter:", self.param)
            return func(*args, **kwargs)
        return wrapper


# Пример использования:
@DecoratorWithParam("example_parameter")
def example_function():
    print("Inside the function")
    return 42