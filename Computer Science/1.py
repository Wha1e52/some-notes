"""
Модель — это набор идей, которые описывают задачу и ее свойства.

Квадратные уравнения так же важны для программиста, как мультиварка — для повара. Они экономят время. Квадратные уравнения помогают быстрее решать множество задач, а это для вас самое главное.

XOR возвращает True, если идеи взаимоисключающие.





"""

def factorial(n):
    result = 1
    for i in range(1, n + 1):
        result *= i
    return result


result = factorial(64)
result2 = factorial(8)
result3 = factorial(64-8)
print(result/result2)