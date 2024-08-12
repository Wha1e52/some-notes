# Инкапсуляция
"""
Инкапсуляция - когда мы объединяем данные и методы, а также скрываем реализацию внутри,
будто помещаем все что нам нужно в отдельную капсулу

Инкапсуляция относится к механизму сокрытия внутренней реализации объекта и предоставлению
только определенного интерфейса для взаимодействия с ним.
"""
# x public
# _x protected
# __x private (to change -> classobj_classname__x)

# a = Point(1, 2)
# a._Point__x                   --> доступ к __n атрибуту


class Point:
    def __init__(self, x=0, y=0):
        self.__x = self.__y = 0
        if self.__check_value(x) and self.__check_value(y):
            self.__x = x
            self.__y = y

    @classmethod
    def __check_value(cls, value):
        return type(value) in (int, float)

    def set_coord(self, x, y):
        if self.__check_value(x) and self.__check_value(y):
            self.__x = x
            self.__y = y
        else:
            raise ValueError('Координаты должны быть числами')

    def get_coord(self):
        return self.__x, self.__y

