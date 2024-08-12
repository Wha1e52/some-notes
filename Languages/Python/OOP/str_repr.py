class Person:
    def __init__(self, name):
        self.__name = name

    def __str__(self):  # отображение информации об объекте класса при print(obj) или str(obj). используется для пользователей
        return self.__name

    def __repr__(self):  # отображение информации об объекте класса для разработчиков
        return f"{self.__class__}: {self.__name}"

    def __len__(self):  # переназначает функцию len() при использовании на объекте класса
        pass

    def __abs__(self):  # переназначает функцию abs() при использовании на объекте класса
        pass


a = Person('Alex')
