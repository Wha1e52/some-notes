# класс — это своего рода инструкция по созданию экземпляров.
class Test:
    """description of my class"""
    a = 1
    b = 2


a = getattr(Test, 'a', False)  # a = Test.a     # (если атрибута нет, вернет False как мы указали)
setattr(Test, 'c', 3)  # Test.c = 3
hasattr(Test, 'c')  # проверяем наличие атрибута
delattr(Test, 'b')  # del Test.b

print(Test.__dict__)  # all attributes of Test
print(Test.__doc__)  # str description
