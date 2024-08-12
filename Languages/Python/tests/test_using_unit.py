# Additional Arguments: discover -s tests -p '*_tests.py'

from unittest import TestCase, main
import doctest


def addiction(a: int, b: int) -> int:
    """
    Сложение a + b
    :param a: Целое число
    :param b: Целое число
    :return: Результат сложения a + b

    >>> addiction(2, 2)
    4
    >>> addiction(2, 3)
    5
    """
    return a + b


# интегрирует doctest и unittest
# def load_tests(loader, tests, ignore):
#     tests.addTests(doctest.DocTestSuite(some_unit_test))  # должно быть имя модуля
#     return tests


class SomeTest(TestCase):
    def test_add(self):
        self.assertEqual(addiction(2, 2), 4)

    def test_raise(self):
        with self.assertRaises(TypeError):
            addiction('2', 1)


if __name__ == '__main__':
    main()
