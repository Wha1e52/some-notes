<!-- Операторы -->
<?php

# arithmetic
echo 1 + 2;
echo 1 - 2;
echo 2 * 2;
echo 4 / 2;
echo 4 % 2; # деление по модулю (для float использовать fmod)
echo 2 ** 3; # возведение в степень

$x = +6; # конвертация в int

# assignment
$var = 1; # = присвоение
$x = $y = 10; # присвоение сразу нескольких переменных
$var2 = &$var; # & присвоение по ссылке (не создается новая ячейка памяти, работаем с указателем)

# комбинированые операторы такие же как в питоне
$var += 1; # $var = $var + 1
$var -= 1;
$var *= 1;
$var /= 1;
$var %= 1;
$var **= 1;


# increment/decrement операторы
$var++; # сначала вернет значние, а потом увеличит на 1
++$var; # сначала увеличит на 1, а потом вернет значние
$var--; # сначала вернет значние, а потом уменьшит на 1
--$var; # сначала уменьшит на 1, а потом вернет значние

# string operators
$str1 = 'hello, ';
$str2 = 'world';

echo $str1 . $str2; # . конкатенация строк
$str1 .= $str2;

# comparison operators
$x = 1;
$y = 2;

echo 1 == 1; # loose comparison
echo 1 === 1; # strict comparison (+ data type check)
echo 1 != 1;
echo 1 <> 1;
echo 1 !== 1;
echo 1 > 1;
echo 1 < 1;
echo 1 >= 1;
echo 1 <= 1;
echo $x <=> $y; # вернет 0 если равны, -1 если $x < $y, 1 если $x > $y

# logical operators
$x = true;
$y = false;

echo $x && $y; # and
echo $x || $y; # or
echo !$x; # not

# array operators
$x = ['a', 'b', 'c'];
$y = ['d', 'e', 'f', 'g', 'h'];
$z = $x + $y; # ['a', 'b', 'c', 'g', 'h'] склеивает массивы если значения не под одним индексом или ключом

$x = ['a' => 1, 'b' => 2, 'c' => 3];
$y = ['a' => 1, 'c' => 3, 'b' => 2];
$z = $x == $y; # true #проверяет равенство ключей и значений
$z = $x === $y; # false #проверяет равенство ключей, значений, типов и порядок

# null coalescing operator
echo $var ?? 'default value'; # если $var не null, то вернет $var, если null, то вернет 'default value'

# nullsafe operator
$user = null;
// если объект, к которому применяется ?->, равен null, выполнение выражения прекратится и вернётся null
$city = $user?->getAddress()?->getCity();
$city = $user?->getAddress() ?? 'not provided';

# null coalescing assignment
$arr = [];
$arr['key'] ??= 'value'; // если $arr['key'] не существует, то присвоит 'value'

# ternary operator:
# условие ? если истина : если ложь
echo $var == 'green' ? 'go' : 'stop';
# если истина, то выведет var, иначе выведет значение после ?:
echo $var ?: 'stop';

# error control operator
$x = @file('file.txt'); # @ - игнорирует ошибки

# bitwise operators
$x = 6;
$y = 3;

echo $x & $y; # and (if both bits are 1)
// 110
// &
// 011
// ---
// 010 = 2

echo $x | $y; # or (if either bit is 1)
// 110
// |
// 011
// ---
// 111 = 7

echo $x ^ $y; # xor (if only one bit is 1, but not both)
// 110
// ^
// 011
// ---
// 101 = 5

echo ~$x; # invert bits
// 110
// ~
// 001

echo $x << 2; # left shift
echo $x >> 2; # right shift
