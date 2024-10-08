# todo Особенности
'''
One of Python's strengths is its diverse and supportive community.
'''
import copy

'''
Суффикс .py в имени файла hello_world.py указывает, что файл является програм-
мой Python. Редактор запускает файл в интерпретаторе Python, который читает
программу и определяет, что означает каждое слово в программе. Например, когда
интерпретатор обнаруживает слово print, он выводит на экран текст, заключенный
в скобки.
'''

# todo Комментарии

'''
Комментарии пишутся прежде всего для того, чтобы объяснить, что должен делать ваш код и как он работает. 
В ходе работы над проектом вы понимаете, как работают все его компоненты. 
Но, если вернуться к проекту спустя некоторое время, скорее всего, некоторые подробности будут забыты.
Хорошие комментарии с доступным изложением общих принципов работы кода сэкономят немало времени.
'''

# todo Строки

'''
Строка представляет собой простую последовательность символов. Любая последовательность символов, заключенная в 
кавычки, в Python считается строкой; при этом строки могут быть заключены как в одиночные, так и в двойные кавычки 
'''

# Возвращают копию строки:

# str.title() Метод title() преобразует первый символ каждого слова в строке к верхнему регистру, тогда как все остальные символы выводятся в нижнем регистре.
    # Ada Lovelace

# str.upper() все к верхнему регистру
    # ADA LOVELACE

# str.lower() все к нижнему регистру
    # ada lovelace

# str.rstrip() удаляет пропуски(' ', '\t', '\n') с правого края, *
# str.lstrip() удаляет пропуски с левого края, *
# str.strip() удаляет пропуски с обоих краев, *
# * если указать символы в качестве аргумента, удалит эти символы с краев

'''
Конкатенация:

first_name = "ada"
last_name = "lovelace"
full_name = first_name + " " + last_name
message = "Hello, " + full_name.title() + "!"
print(message)

# сохранение текста сообщения в переменной существенно упрощает завершающую команду печати (print)
'''

# todo Числа

'''
+, -, *, /, //, **
Целые числа (int), Вещественные числа (float)
'''

# todo Списки

'''
Список — это набор элементов, следующих в определенном порядке. Так как список обычно 
содержит более одного элемента, рекомендуется присваивать спискам имена
во множественном числе: letters, digits, names и т. д.
Списки представляют собой упорядоченные наборы данных
'''

# ----------------------------Изменение элемента в списке:

# motorcycles = ['honda', 'yamaha', 'suzuki']
# motorcycles[0] = 'ducati'

# ['ducati', 'yamaha', 'suzuki']

# ----------------------------Присоединение элементов в конец списка:

# motorcycles = ['honda', 'yamaha', 'suzuki']
# motorcycles.append('ducati')

# ['honda', 'yamaha', 'suzuki', 'ducati']

# ----------------------------Вставка элементов в список по индексу:

# motorcycles = ['honda', 'yamaha', 'suzuki']
# motorcycles.insert(0, 'ducati')

# ['ducati', 'honda', 'yamaha', 'suzuki']

# ----------------------------Удаление элемента по индексу:

# motorcycles = ['honda', 'yamaha', 'suzuki']
# del motorcycles[0]

# ['yamaha', 'suzuki']

# ----------------------------Удаление элемента с использованием метода pop():

# - удаляет последний элемент из списка, но позволяет работать с ним после удаления.
# - может использоваться для удаления элемента в произвольной позиции списка; для этого следует указать индекс удаляемого элемента в круглых скобках.

# motorcycles = ['honda', 'yamaha', 'suzuki']
# popped_motorcycle = motorcycles.pop()

# ['honda', 'yamaha']

# ----------------------------Удаление элементов по значению:

# - Метод remove() удаляет только ПЕРВОЕ ВХОЖДЕНИЕ заданного значения.

# motorcycles = ['honda', 'yamaha', 'suzuki', 'ducati']
# motorcycles.remove('ducati')

# ['honda', 'yamaha', 'suzuki']

# ----------------------------Постоянная сортировка списка методом sort():

# Метод sort() осуществляет постоянное изменение порядка элементов в самом списке и вернуться к исходному порядку уже не удастся
# Список также можно отсортировать в обратном алфавитном порядке; для этого методу sort() следует передать аргумент reverse=True.

# cars = ['bmw', 'audi', 'toyota', 'subaru']
# cars.sort()

# ['audi', 'bmw', 'subaru', 'toyota']

# ----------------------------Временная сортировка списка функцией sorted():

# Функция sorted() возвращает отсортированную КОПИЮ и не изменяет сам список.
# Функции sorted() также можно передать аргумент reverse=True

# sorted_cars = sorted(cars, reverse=True)

# ['toyota', 'subaru', 'bmw', 'audi']

# ----------------------------Вывод списка в обратном порядке:

# Метод reverse() осуществляет постоянное изменение порядка элементов, но вы можете легко вернуться к исходному порядку,
# снова применив reverse() к обратному списку.

# cars = ['bmw', 'audi', 'toyota', 'subaru']
# cars.reverse()  # ['subaru', 'toyota', 'audi', 'bmw']
# reverse_cars = cars[::-1] - вернет копию обратного порядка

# ----------------------------Определение длины списка:

# cars = ['bmw', 'audi', 'toyota', 'subaru']
# len(cars)

# ----------------------------Использование range() для создания числового списка

# numbers = list(range(1, 6))
# print(numbers) -> [1, 2, 3, 4, 5]

# ----------------------------Функции min, max, sum

# digits = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0]

# min(digits) # 0
# max(digits) # 9
# sum(digits) # 45

# ----------------------------Копирование списка

my_list = [1, 2, 3]
# shallow_copy:
#   my_copy = my_list[:]
#   ||
#   my_copy = my_list.copy()
#   ||
#   my_copy = list(my_list)
# deep copy:
#   my_copy = copy.deepcopy(my_list)

# todo Кортежи

'''
Значения, которые не могут изменяться, называются неизменяемыми (immutable), а неизменяемый список называется кортежем.
Кортеж выглядит как список, не считая того, что вместо квадратных скобок используются круглые скобки
'''

# dimensions = (200, 50)

# todo Команды if

'''
Команда if в языке Python позволяет проверить текущее состояние программы и выбрать дальнейшие действия 
в зависимости от результатов проверки. 
Python выполняет только один блок в цепочке if-elif-else. 
Все условия проверяются по порядку до тех пор, пока одно из них не даст истинный результат. 
Далее выполняется код, следующий за этим условием, а все остальные проверки Python пропускает.
Код может содержать сколько угодно блоков elif.
Если вы хотите, чтобы в программе выполнялся только один блок кода, — используйте цепочку if-elif-else. 
Если же выполняться должны несколько блоков, используйте серию независимых команд if.
'''

# age = 12
# if age < 4:
#     price = 0
# elif age < 18:
#     price = 5
# elif age < 65:
#     price = 10
# else:
#     price = 5
# print("Your admission cost is $" + str(price) + ".")

# ----------------------------Операторы сравнения:

# ==, !=, <, <=, >, >=

# ----------------------------Ключевые слова and и or:

# and:

# Чтобы проверить, что два условия истинны одновременно,
# объедините их ключевым словом and; если оба условия истинны,
# то и все выражение тоже истинно. Если хотя бы одно (или оба) условия ложны,
# то и результат всего выражения равен False.

# age_0 = 22
# age_1 = 18
# age_0 >= 21 and age_1 >= 21

# or

# Ключевое слово or тоже позволяет проверить несколько условий,
# но результат общей проверки является истинным в том случае,
# когда истинно хотя бы одно или оба условия.
# Ложный результат достигается только в том случае, если оба отдельных условия ложны.

# age_0 = 22
# age_1 = 18
# age_0 >= 21 or age_1 >= 21

# ----------------------------Проверка вхождения значений в список

# Чтобы узнать, присутствует ли заданное значение в списке, воспользуйтесь ключевым словом in

# banned_users = ['andrew', 'carolina', 'david']
# user = 'marie'
# if user not in banned_users:
#     print(user.title() + ", you can post a response if you wish.")

# todo Словари

'''
Использование синтаксиса с ключом в квадратных скобках для получения интересующего вас значения из словаря 
имеет один потенциальный недостаток: если запрашиваемый ключ не существует, то вы получите сообщение об ошибке.
'''

# alien_0 = {'color': 'green', 'points': 5}
# color = alien_0['color']
# print(color)  ->  green

# alien_0['x_position'] = 0
# alien_0['y_position'] = 25
# alien_0['color'] = 'yellow'

# print(alien_0)   ->   {'color': 'yellow', 'points': 5, 'y_position': 25, 'x_position': 0}

# ---------------------------- Обращение к значениям методом get
'''
Если ключ существует в словаре, вы получите соответствующее значение; если нет — будет получено значение по умолчанию.
Если 2й аргумент опущен, то по умолчанию будет - None
'''

# color2 = alien_0.get('color', 'Не найдено')
# print(color2)  ->  Не найдено

# ---------------------------- Удаление пар "ключ-значение"

# del alien_0['points']

# ---------------------------- Перебор ключей словаря:

# favorite_languages = {
# 'jen': 'Python',
# 'sarah': 'c',
# 'edward': 'ruby',
# 'phil': 'Python',
# }

# ---------------Перебираем пары ключ-значение

# for name, language in favorite_languages.items():  ('jen', 'Python'), ...
#     pass

# ---------------Перебираем только ключи
"for name in favorite_languages: == for name in favorite_languages.keys():"

# for name in favorite_languages.keys():  'jen', ...
#     pass

# ---------------Перебираем только значения

# for language in favorite_languages.values():  'Python', ...
#     pass


# todo Функции

'''
Функции - это именованные блоки кода, предназначенные для решения одной конкретной задачи.
Существуют несколько способов передачи аргументов функциям: 
Позиционные аргументы перечисляются в порядке, точно соответствующем порядку записи параметров (Если нарушить порядок 
следования аргументов в вызове при использовании позиционных аргументов, возможны неожиданные результаты).
Именованные аргументы состоят из имени переменной и значения
Все параметры со значением по умолчанию должны следовать после параметров, у которых значений по умолчанию нет.

Все что слева от / в параметрах функции обязательно должно быть позиционными аргументами
Все что справа от * в параметрах функции обязательно должно быть именованными аргументами (не путать с *args)
def test(first, last, /,  *, x, y=20):

Все позиционные аргументы идут в параметр *args, именованные в **kwargs
def test(*args, **kwargs):
test(1, 2, 3, x=1, y=4) # args = (1, 2, 3), kwargs = {'x': 1, 'y': 4}
'''

# todo Стандартная библиотека

# -------------------------------------------------------- random ------------------------------------------------------
# from random import randint, choice

# randint(1, 6) -> вернет случайное число (от, до)
# r = choice([1, 2, 3, 4, 5]) -> вернет случайный элемент

# -------------------------------------------------------- json --------------------------------------------------------
# import json

# Запись файла

# numbers = [2, 3, 5, 7, 11, 13]
# filename = 'numbers.json'
# with open(filename, 'w') as f_obj:
#     json.dump(numbers, f_obj)

# Загрузка файла

# filename = 'numbers.json'
# with open(filename) as f_obj:
#     numbers = json.load(f_obj)


# json.dumps() - переводит словарь в строку
# json.loads() - переводит строку в словарь

# ----------------------------------------------------------------------------------------------------------------------
# todo Итераторы
"""
Итерируемый объект — это любой объект, от которого встроенная функция iter() может получить итератор.

Итератор в python — это любой объект, реализующий дандер-метод __next__, который должен вернуть 
следующий элемент или ошибку StopIteration. 
Также он реализует дандер-метод __iter__ и поэтому сам является итерируемым объектом.
"""

# todo Генераторы
"""
Генераторы – это реализация паттерна проектирования Итератор.

Этот паттерн позволяет «лениво» определять последовательности данных и обходить их поэлементно.
Это полезно, когда последовательность потенциально велика и сохранить ее в памяти целиком невозможно.

Простой синхронный генератор – это обычная функция Python, содержащая предложение yield вместо return.
Функция-генератор при вызове всегда возвращает объект-генератор.
генераторы, одноразовые, если его перебрали он закончился



"""

def positive_integers(until: int):
    for integer in range(until):
        yield integer


positive_iterator = positive_integers(2)
print(next(positive_iterator))
print(next(positive_iterator))




































































































# ################################ else в конце цикла #################################

for i in range(10):
    if i > 4:
        break
else:
    print('Отработало без breaks')  # отработает если не было 'break'

print('Done')

# ################################ list[:] #################################

my_list = [1, 2, 3]
my_copy = my_list[:]  # --> my_copy = my_list.copy() = list(my_list)

# ################################ print(sep='', end='') #################################
# можно поиграть с выводом принта

# ################################ mutable and immutable #################################

# immutable:

a = 'some string'
x = 7  # id = 2420461207984, print -> 7
y = x  # id = 2420461207984, print -> 7
x = 4  # id = 2322624938320 print -> 4
print(y)  # -> 7, id 'y' останется прежним(что естественно, это ведь совершенно другой объект)
z = (1, 2, 3)

# mutable:

some_list = ['a', 'b', 'c']  # id = 2237556638848, print -> ['a', 'b', 'c']
some_list2 = some_list  # id = 2237556638848, print -> ['a', 'b', 'c']
some_list.append('d')
print(id(some_list))  # id = 2237556638848, print -> ['a', 'b', 'c', 'd'] оба ссылаются на один объект
print(id(some_list2))  # id = 2237556638848, print -> ['a', 'b', 'c', 'd'] оба ссылаются на один объект

# ################################ tuple #################################

var1 = ('abc')  # <---- str
var2 = ('abc',)  # <---- tuple (всегда нужна запятая)

# ################################ assert #################################

# The assert keyword lets you test if a condition in your code returns True,
# if not, the program will raise an AssertionError.

var = "hello"

# if condition returns False, AssertionError is raised:
assert var == "goodbye", "var should be 'hello'"

# ################################ unpacking #################################

values = [1, 2, 3, 4, 5]
first, *middle, last = values
print(first)   # 1
print(middle)  # [2, 3, 4]
print(last)    # 5

v, _, c = (1, 2, 3)  # Пропуск второго значения
print(v)  # 1
print(c)  # 3

defaults = {"color": "blue", "size": "medium"}
user_prefs = {"size": "large"}
final_prefs = {**defaults, **user_prefs}

print(final_prefs)  # {'color': 'blue', 'size': 'large'}

# ################################ uuid #################################
import uuid

# Генерация случайного UUID
random_uuid = uuid.uuid4()
print(random_uuid)

# Генерация UUID на основе имени объекта и пространства имен
name_uuid = uuid.uuid5(uuid.NAMESPACE_URL, 'example.com')
print(name_uuid)

uuid_string = '474b1e50-64ef-4393-b145-47c59a4897d2'
uuid_obj = uuid.UUID(uuid_string)

print("Version:", uuid_obj.version)  # Версия UUID
print("Variant:", uuid_obj.variant)  # Вариант UUID

# ################################ try-except #################################

try:
    1 / 0
except ZeroDivisionError:
    print("на ноль делить нельзя")
else:
    print("отработает если нет ошибок в try")
finally:
    print("This code always executes")

# если try-except-finally определен внутри функции, то код в finally выполняется перед return

# ################################ decorators #################################
from functools import wraps


def my_decorator(func):
    @wraps(func)
    def wrapper(*args, **kwargs):
        print('1')
        res = func(*args, **kwargs)
        print('2')
        return res

    # wrapper.__name__ = func.__name__
    # wrapper.__doc__ = func.__doc__
    return wrapper


@my_decorator
def do_smth():
    return 1 + 4
