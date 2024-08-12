class Test:
    def __init__(self, x, y):
        self.x = x
        self.y = y

    def __getattribute__(self, item):  # автоматически вызывается при получении свойства класса с именем item (pt1.x)
        if item == 'x':
            raise ValueError('доступ запрещен')
        else:
            return object.__getattribute__(self, item)

    def __setattr__(self, key, value):  # автоматически вызывается при изменении свойства key класса (pt1.x = 10)
        if key == 'z':
            return AttributeError('недопустимое имя атрибута')
        else:
            object.__setattr__(self, key, value)

    def __getattr__(self, item):  # автоматически вызывается при получении несуществующего свойства item класса (pt1.v)
        return False

    def __delattr__(self, item):  # автоматически вызывается при удалении свойства item (del pt1.x)
        object.__delattr__(self, item)


pt1 = Test(1, 2)
