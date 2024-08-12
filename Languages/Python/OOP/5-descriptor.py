# Descriptor

class Descriptor:
    @classmethod
    def verify_coord(cls, coord):
        if type(coord) != int:
            raise TypeError('Координата должна быть целым числом')

    def __set_name__(self, owner, name):
        self.name = '_' + name

    def __get__(self, instance, owner):
        return getattr(instance, self.name)

    def __set__(self, instance, value):
        self.verify_coord(value)
        setattr(instance, self.name, value)


class Point:
    x = Descriptor()
    y = Descriptor()
    z = Descriptor()

    def __init__(self, x, y, z):
        self.x = x  #вызывается дискриптор т.к происходит назначение(__set__)
        self.y = y
        self.z = z


pt = Point(1, 2, 3)
print(pt.__dict__)
