"""
todo S - Single Responsibility Principle (SRP) - Принцип единственной ответственности

Каждый класс должен иметь только одну зону ответственности.
A class should have only one reason to change.
Having a single responsibility doesn’t necessarily mean having a single method.

Назначение:
Принцип служит для разделения типов поведения, благодаря которому ошибки, вызванные модификациями в одном поведении,
не распространялись на прочие, не связанные с ним типы.

Пример:

from pathlib import Path
from zipfile import ZipFile

class FileManager:
    def __init__(self, filename):
        self.path = Path(filename)

    def read(self, encoding="utf-8"):
        return self.path.read_text(encoding)

    def write(self, data, encoding="utf-8"):
        self.path.write_text(data, encoding)

    def compress(self):
        with ZipFile(self.path.with_suffix(".zip"), mode="w") as archive:
            archive.write(self.path)

    def decompress(self):
        with ZipFile(self.path.with_suffix(".zip"), mode="r") as archive:
            archive.extractall()
______________________________________________________________________________

from pathlib import Path
from zipfile import ZipFile

class FileManager:
    def __init__(self, filename):
        self.path = Path(filename)

    def read(self, encoding="utf-8"):
        return self.path.read_text(encoding)

    def write(self, data, encoding="utf-8"):
        self.path.write_text(data, encoding)

class ZipFileManager:
    def __init__(self, filename):
        self.path = Path(filename)

    def compress(self):
        with ZipFile(self.path.with_suffix(".zip"), mode="w") as archive:
            archive.write(self.path)

    def decompress(self):
        with ZipFile(self.path.with_suffix(".zip"), mode="r") as archive:
            archive.extractall()

Now we have two smaller classes, each having only a single responsibility.

________________________________________________________________________________________________________________________
todo O - Open Closed Principle (OCP) - Принцип открытости/закрытости

Программные сущности (классы, модули, функции и т.п.) должны быть открыты для расширения, но закрыты для изменения.
Возможность добавлять новый функционал, не изменяя старый.

Назначение:
Принцип служит для того, чтобы делать поведение класса более разнообразным, не вмешиваясь в текущие операции,
которые он выполняет. Благодаря этому вы избегаете ошибок в тех фрагментах кода, где задействован этот класс.

Пример:

from math import pi

class Shape:
    def __init__(self, shape_type, **kwargs):
        self.shape_type = shape_type
        if self.shape_type == "rectangle":
            self.width = kwargs["width"]
            self.height = kwargs["height"]
        elif self.shape_type == "circle":
            self.radius = kwargs["radius"]

    def calculate_area(self):
        if self.shape_type == "rectangle":
            return self.width * self.height
        elif self.shape_type == "circle":
            return pi * self.radius**2
______________________________________________________________________________
from abc import ABC, abstractmethod
from math import pi

class Shape(ABC):
    def __init__(self, shape_type):
        self.shape_type = shape_type

    @abstractmethod
    def calculate_area(self):
        pass

class Circle(Shape):
    def __init__(self, radius):
        super().__init__("circle")
        self.radius = radius

    def calculate_area(self):
        return pi * self.radius**2

class Rectangle(Shape):
    def __init__(self, width, height):
        super().__init__("rectangle")
        self.width = width
        self.height = height

    def calculate_area(self):
        return self.width * self.height

class Square(Shape):
    def __init__(self, side):
        super().__init__("square")
        self.side = side

    def calculate_area(self):
        return self.side**2

________________________________________________________________________________________________________________________
todo L - Liskov Substitution Principles (LSP) - Принцип подстановки Барбары Лисков

Объекты подклассов могут заменять объекты родительских классов, без негативных последствий
для функциональности программы.


Назначение:
Принцип служит для того, чтобы обеспечить постоянство:
класс-родитель и класс-потомок могут использоваться одинаковым образом без нарушения работы программы.
In practice, this principle is about making your subclasses behave like their base classes
without breaking anyone’s expectations when they call the same methods.

Пример:

from abc import ABC, abstractmethod

class Shape(ABC):
    @abstractmethod
    def calculate_area(self):
        pass

class Rectangle(Shape):
    def __init__(self, width, height):
        self.width = width
        self.height = height

    def calculate_area(self):
        return self.width * self.height

class Square(Shape):
    def __init__(self, side):
        self.side = side

    def calculate_area(self):
        return self.side ** 2


def get_total_area(shapes):
    return sum(shape.calculate_area() for shape in shapes)

get_total_area([Rectangle(10, 5), Square(5)])

Shape becomes the type that you can substitute through polymorphism with either Rectangle or Square,
which are now siblings rather than a parent and a child. Notice that both concrete shape types have distinct
sets of attributes, different initializer methods, and could potentially implement even more separate behaviors.
The only thing that they have in common is the ability to calculate their area.
Because the function only cares about the .calculate_area() method, it doesn’t matter that the shapes are different.
________________________________________________________________________________________________________________________
todo I - Interface Segregation Principle (ISP) - Принцип разделения интерфейса

Программные сущности не должны зависеть от методов, которые они не используют.
Лучше иметь много специализированных интерфейсов, чем один общий.

Назначение:
Принцип служит для того, чтобы раздробить единый набор действий на ряд наборов поменьше – таким образом,
каждый класс делает то, что от него действительно требуется, и ничего больше.

Пример:

from abc import ABC, abstractmethod

class Printer(ABC):
    @abstractmethod
    def print(self, document):
        pass

    @abstractmethod
    def fax(self, document):
        pass

    @abstractmethod
    def scan(self, document):
        pass

class OldPrinter(Printer):
    def print(self, document):
        print(f"Printing {document} in black and white...")

    def fax(self, document):
        raise NotImplementedError("Fax functionality not supported")

    def scan(self, document):
        raise NotImplementedError("Scan functionality not supported")

class ModernPrinter(Printer):
    def print(self, document):
        print(f"Printing {document} in color...")

    def fax(self, document):
        print(f"Faxing {document}...")

    def scan(self, document):
        print(f"Scanning {document}...")
_________________________________________________________

from abc import ABC, abstractmethod

class Printer(ABC):
    @abstractmethod
    def print(self, document):
        pass

class Fax(ABC):
    @abstractmethod
    def fax(self, document):
        pass

class Scanner(ABC):
    @abstractmethod
    def scan(self, document):
        pass

class OldPrinter(Printer):
    def print(self, document):
        print(f"Printing {document} in black and white...")

class NewPrinter(Printer, Fax, Scanner):
    def print(self, document):
        print(f"Printing {document} in color...")

    def fax(self, document):
        print(f"Faxing {document}...")

    def scan(self, document):
        print(f"Scanning {document}...")
________________________________________________________________________________________________________________________
todo D - Dependency Inversion Principle (DIP) - Принцип инверсии зависимости

Модули верхнего уровня не должны зависеть от модулей нижнего уровня. И те, и другие должны зависеть от абстракций.
Абстракции не должны зависеть от деталей. Детали должны зависеть от абстракций.

Принцип гласит, что ни интерфейс, ни класс, не обязаны вникать в специфику работы инструмента.
Напротив, это инструмент должен подходить под требования интерфейса.

Назначение:
Этот принцип служит для того, чтобы устранить зависимость классов верхнего уровня от классов нижнего уровня
за счёт введения интерфейсов.

Пример:

class FrontEnd:
    def __init__(self, back_end):
        self.back_end = back_end

    def display_data(self):
        data = self.back_end.get_data_from_database()
        print("Display data:", data)

class BackEnd:
    def get_data_from_database(self):
        return "Data from the database"
_________________________________________________________
from abc import ABC, abstractmethod

class FrontEnd:
    def __init__(self, data_source):
        self.data_source = data_source

    def display_data(self):
        data = self.data_source.get_data()
        print("Display data:", data)

class DataSource(ABC):
    @abstractmethod
    def get_data(self):
        pass

class Database(DataSource):
    def get_data(self):
        return "Data from the database"

class API(DataSource):
    def get_data(self):
        return "Data from the API"


db_front_end = FrontEnd(Database())
db_front_end.display_data()

Display data: Data from the database

api_front_end = FrontEnd(API())
api_front_end.display_data()

Display data: Data from the API

"""
