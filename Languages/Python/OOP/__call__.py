# __call__

class Test:
    def __init__(self, fn):
        self.fn = fn

    def __call__(self, *args, **kwargs):  # будет вызываться если использовать () к объекту класса
        print(args)
        return self.fn(*args) * 2


@Test
def add(x, y):
    return x + y

print(add(2, 3))
