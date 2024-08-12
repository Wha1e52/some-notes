import pytest

from test_using_unit import addiction


def test_add():
    assert addiction(2, 2) == 4


def test_add2():
    assert addiction(2, 3) == 5


def test_raise():
    with pytest.raises(TypeError):
        addiction('2', 1)
