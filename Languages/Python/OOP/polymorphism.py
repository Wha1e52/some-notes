"""
Полиморфизм - это принцип объектно-ориентированного программирования, который позволяет объектам с одним
интерфейсом иметь различную реализацию. Это означает, что мы можем использовать один и тот же метод или функцию для
объектов разных классов и получать различный результат.

"""


class Animal:
    def make_sound(self):
        pass


class Dog(Animal):
    def make_sound(self):
        return "Woof!"


class Cat(Animal):
    def make_sound(self):
        return "Meow!"


class Cow(Animal):
    def make_sound(self):
        return "Moo!"


# Функция, использующая полиморфизм
def make_animal_sound(animal):
    print(animal.make_sound())


# Создание объектов разных классов
dog = Dog()
cat = Cat()
cow = Cow()

# Вызов функции с объектами разных классов
make_animal_sound(dog)  # Вывод: Woof!
make_animal_sound(cat)  # Вывод: Meow!
make_animal_sound(cow)  # Вывод: Moo!
