class Test:
    def __init__(self, x, y, grades=(1, 2, 3, 4, 5)):
        self.x = x
        self.y = y
        self.grades = list(grades)
        self.value = 0

        # Переопределение арифм. методов, чтобы работать непосредственно с экземплярами класса, а не его атрибутами:
        # Test(1, 3) + Test(2, 0)

    def __add__(self, other):
        return self.x + self.y
        
    def __sub__(self, other):
        return self.x - self.y

    def __mul__(self, other):
        return self.x * self.y

    def __truediv__(self, other):
        return self.x / self.y
       
    def __floordiv__(self, other):
        return self.x // self.y

    def __mod__(self, other):
        return self.x % self.y

    # Переопределение (синтаксического сахара) арифм. методов:

    def __iadd__(self, other):  # a += 1
        pass

    def __isub__(self, other):  # a -= 1
        pass

    # и т.д...

    # Переопределение методов сравнения:
    # необязательно прописывать все, можно только 3(==, <, <=), остальные инвертируются автоматически

    def __eq__(self, other):  # для равенства ==
        pass

    def __ne__(self, other):  # для неравенства !=
        pass

    def __lt__(self, other):  # для оператора меньше <
        pass

    def __le__(self, other):  # для оператора меньше или равно <=
        pass

    def __gt__(self, other):  # для оператора больше >
        pass

    def __ge__(self, other):  # для оператора больше или равно >=
        pass

    # Переопределение метода hash():

    def __hash__(self):
        return hash((self.x, self.y))

    # Переопределение метода bool():
    def __bool__(self):
        return self.x == self.y

    # Чтобы можно было работать по индексу через объект класса (obj[i]):

    def __getitem__(self, item):
        return self.grades[item]

    def __setitem__(self, key, value):
        self.grades[key] = value

    def __delitem__(self, key):
        del self.grades[key]

    # Создаем итератор из объекта класса:

    def __iter__(self):
        return self

    def __next__(self):
        if self.value < 100:
            self.value += 1
            return self.value
        raise StopIteration

a = Test(2, 2)

print(a + 10)  # -> 4 (2(x) + 2(y))
a[0] = 10
del a[4]


