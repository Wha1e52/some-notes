class Vector:
    MIN_COORD = 0
    MAX_COORD = 100

    @classmethod                                        # для работы с атрибутами класса (MIN_COORD, MAX_COORD)
    def validate(cls, num):
        if type(num) is int or type(num) is float:
            return cls.MIN_COORD <= num <= cls.MAX_COORD
        return False

    def __init__(self, x, y):
        self.x = self.y = 0
        if self.validate(x) and self.validate(y):
            self.x = x
            self.y = y

    @staticmethod                  # функция, которая связана с классом, но не зависит от его экземпляров или атрибутов
    def norm2(x, y):
        return x*x + y*y


ss = Vector(2.2, 2)
ss.gh

