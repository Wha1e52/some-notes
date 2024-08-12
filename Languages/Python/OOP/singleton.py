# 1)

class DataBase:
    """Singleton"""
    __instance = None

    def __new__(cls, *args, **kwargs):
        if cls.__instance is None:
            cls.__instance = super().__new__(cls)
        return cls.__instance

    def __del__(self):
        DataBase.__instance = None

    def __init__(self, user, psw, port):
        self.user = user
        self.psw = psw
        self.port = port


p1 = DataBase(100, 2, 3)
p2 = DataBase(200, 2, 23)
print(p1.port, p2.port)


# 2) назначить экземпляр класса в переменную, импортировать и использовать только ее
# 3) закешировать функцию через декоратор @lru_cache и вернуть экземпяр класса
from functools import lru_cache


class MyClass:
    def __init__(self, value):
        self.value = value


@lru_cache(maxsize=None)
def cached_function(value):
    return MyClass(value)


instance1 = cached_function(1)
instance2 = cached_function(2)


print(instance1.value)  # Выведет: 1
print(instance2.value)  # Выведет: 2
"""
В этом примере функция cached_function использует декоратор @lru_cache для кэширования результатов выполнения 
функции с разными входными параметрами value и возвращает экземпляр класса MyClass. 
Каждый уникальный value будет приводить к созданию нового экземпляра MyClass, 
иначе будет использоваться закешированный результат.
"""
