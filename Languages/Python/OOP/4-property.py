# property

class Person:
    def __init__(self, name, old):
        self.__name = name
        self.__old = old

    # def get_old(self):
    #     return self.__old
    #
    # def set_old(self, old):
    #     self.__old = old
    #
    # old = property(get_old, set_old)
    # либо
    # old = property()
    # old.setter(set_old)
    # old.getter(get_old)

    @property
    def old(self):
        return self.__old

    @old.setter
    def old(self, old):
        self.__old = old

    @old.deleter
    def old(self):
        del self.__old


a = Person('sam', 4)
a.old = 2
print(a.old, a.__dict__)
