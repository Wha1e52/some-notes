<?php
    declare(strict_types=1); # декларируем строгую типизацию
    error_reporting(E_ALL); # Сообщать о каждой PHP-ошибке
?>

<!-- Комментарии -->
<?php
// однострочный комментарий
# тоже однострочный комментарий

/*
многострочный комментарий
*/
?>

<?php
echo 'hello'; # обычный принт, можно использовать print вместо echo
echo 123; // под капотом приводится к строке (string) и потом выводится
?>

<?= '<p>hello</p>' ?> == <?php echo '<p>hello</p>'?>

<!-- Переменные -->
<?php

$var = 'hello world';
$var2 = "It's a cat. $var";
$var22 = "It's a cat. {$var}"; # для читабельности можно обернуть фигурными скобками
$var5 = 'bar';
$$var5 = 'foo'; # $bar = 'foo' (вместо $$var5 подставляется значение из $var5)
$var3 = <<<HERE
It's a cat. $var. "some str".
HERE; # аналог множественных f-строк питона
$var4 = <<<'HERE'
It's a cat. "some str".
HERE; # аналог множественных обычных строк питона

# константы:
const TITLE = 'my title'; # константа (определяется во время компиляции)
define("SOMECONSTANT", "Hello world."); # константа (определяется во время выполнения)

echo TITLE; # вывод констант без $
echo defined('TITLE'); # проверка на существование константы

echo NAN; # не число
echo INF; # бесконечность
?>

<!-- Типы данных -->
<?php
# scalar types
$var_bool = true | false;
// 0, -0, 0.0, -0.0, '0', '', null, [] === false
$var_int = 12;
$var_float = 3.14; // никогда не сравнивай float === float
$var_string = 'hello world';

# compound types
$array = ['cat', 2, 3.1, 'dog', 'bird'];
$array2 = ['title' => 'my cat', 'price' => 50, 'description' => 'some description']; # тоже считается array
#object
#callable
#iterable

# special types
$var_null = null;
#resource

?>
<!-- приведение типов данных -->
<?php
var_dump((int) '123');
var_dump((float) 123);
var_dump((string) 123);
var_dump((0.1 * 10 + 0.2 * 10) / 10); # как избежать проблем плавающей точки 0.200000004
// при приведении строки к (int)/(float) если строка не число, будет 0
?>

<!-- Полезные функции -->
<?php
$some_var = 123;
$some_arr = [1, 2, 3];
$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
echo json_encode($arr); # преобразует массив в json
var_dump($some_var); # показывает что лежит в переменной и какого она типа
var_dump(is_bool($some_var)); # проверяет, является ли переменная bool
var_dump(is_int($some_var)); # проверяет, является ли переменная integer

error_reporting(-1); # выводит лог ошибок
echo gettype($some_var); # показывает какого типа переменная
unset($some_var); # стирает переменную из памяти
print_r($some_list); # выводит элементы массива, менее детально чем var_dump
phpinfo(); # вывод информации по пхп
$p_hash = password_hash('password', PASSWORD_DEFAULT); # получить хеш пароля
$is_verified =  password_verify('password', $p_hash); # сверить хеш и пароль
echo floor(11.5); # округляет в меньшую сторону
echo ceil(11.5); # округляет в большую сторону
echo is_infinite(2); # проверяет на бесконечность
echo is_finite(1); # проверяет на не бесконечность
echo is_nan(2); # проверяет на не число
echo is_null(12); # проверяет на null (12 === null)
# copy('file.txt', 'folder/file.txt')
# rename('file.txt', 'file2.txt')
# file_exists('folder/file.txt')
# file_get_contents('folder/file.txt') читает и помещает в строку
# file_put_contents('folder/file.txt', 'new text', FILE_APPEND)
# file('folder/file.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) читает и помещает в массив
# mkdir('folder/another')
# rmdir('folder/another')
# unlink('folder/file.txt') удаляет файл
?>



<!-- Условия -->

<?php

$a = 1;
$b = 2;

if ($a > $b) {
    echo "a больше b";
} elseif ($a == $b) {
    echo "a равно b";
} else {
    echo "a меньше b";
}

# alternative syntax for if in html
$_ = <<< HERE
<?php $a = 5 ?>
<?php if ($a == 5): ?>
A равно 5
<?php elseif ($a < 5): ?>
A меньше 5
<?php else: ?>
другое
<?php endif; ?>
HERE;

# match-case в питоне
$a = 5;
# не забудь break
// если передадим функцию, то выполняется только 1 раз и потом только сравнивает результат
switch ($a){
    case 1:
        echo '1';
        break;
    case 2:
        echo '2';
        break;
    case 3:
        echo '3';
        break;
    default:
        echo 'else';
}

# всегда должно что-то возвращаться (пишем дефолт всегда)
# строгое сравнение ===
$food = 'cake';
$return_value = match ($food) {
    'apple' => 'На столе лежит яблоко',
    'banana', 'банан' => 'На столе лежит банан',
    'cake' => 'На столе стоит торт',
    default => 'else',
};

?>

<!-- Циклы -->

<?php

# while

$year = 1900;
echo '<select>';

while ($year <= 2024) {
    echo "<option value='$year'>$year</option>";
    $year++;
}

echo '</select>';


$x = 0;
while (true) {
    while ($x > 20) {
        break 2;       # break n - выход из n вложенных циклов
    }
    $x++;
}

$x = 0;
do {
    echo $x++;
} while ($x <= 10);

# for
    
# счетчик, условие, действие. более краткая версия while
for ($i = 1900; $i <= 2024; $i++) {
    echo $i . "<br>";
}

# alternative syntax for for
for ($i = 1900; $i <= 2024; $i++):
    echo $i . "<br>";
endfor;

# foreach
$some_list3 = ['cat', 2, 3.1, 'dog', 'bird'];
$dict3 = ['title' => 'my cat', 'price' => 50, 'description' => 'some description'];

# простой цикл как в питоне, только выводит значения
foreach ($some_list3 as $value) {
    echo $value . "<br>";
}

# с ключем
foreach ($some_list3 as $key => $value) {
    echo "Key: $key, Value: $value" . "<br>";
}
# временная переменная остается после цикла

# для изменения значений во время цикла нужно приписать & (foreach ($some_list3 as &$value))
# и после цикла уничтожить переменную unset($value); обязательно (при работе с &)
foreach ($some_list3 as $key => &$value) {
    echo "Key: $key, Value: $value" . "<br>";
}
unset($value);


# alternative syntax for foreach
foreach ($some_list3 as $value):
    echo $value . "<br>";
endforeach;

    # break, continue такие же как в питоне
?>

<!-- работа с массивами array -->
<?php

$list = ['cat', 'dog', 'bird', 'cat'];
# ||
$list1 = array('cat', 'dog', 'bird', 'cat');
print_r($list); # выводит элементы массива, менее детально чем var_dump
echo $list[0]; # получаем элемент по индексу (ОТРИЦАТЕЛЬНОГО ИНДЕКСА НЕТ !!!)
unset($list[3]); # удаляет элемент (ре-идексирования не будет)
unset($list); # удаляет массив
$list2 = [2 => 'cat', 'dog', 'bird']; # указываем с какого идекса начать индексацию, либо указываем явно для каждого
$list3 = ['title' => 'my cat', 'price' => 50, 'description' => 'some description'];
echo $list3['price']; # получаем значение по ключу
$list3['new_key'] = 'new value'; # добавляем новую пару ключ-значение
$list[] = 'whale'; # добавление 1 нового элемента в конец
$list[2] = 'duck'; # изменение элемента по индексу
// отрицательного индекса в массивах нет, [-1] не сработает
echo count($list); # length в пайтон
echo count($list2, COUNT_RECURSIVE); # рекурсивно посчитать все, в том числе и вложеные элементы. для многомерных
print_r(array_count_values($list)); # посчитать кол-во каждого элемента (как каунтер в питоне)
echo array_key_exists('first', $list); # проверка на присутвие ключа в массиве
var_dump(isset($list[5])); # проверяет наличие элемента в массиве
echo in_array('second', $list); # проверка на присутвие значения в массиве
$key_list3 = array_keys($list3); # возвращает только ключи
$value_list3 = array_values($list3); # возвращает только значения
$merged_list = array_merge($list, $list3); # объединение массивов (строковые ключи при одинаковых - перезаписываются)
$merged_list2 = $list + $list3; # объединение массивов (одинаковые ключи не добавятся из второго массива)
$random = array_rand($merged_list, 2); # получить рандомный элемент или несколько. вернет ключи
$rev_arr = array_reverse($merged_list); # перевернуть массив в обратном порядке
$key = array_search('green', $list3); #  поиск первого найденного элемента, возвращает ключ
$animal = array_shift($list); # извлекает первый элемент (с последующей ре-идексировкой)
$animal2 = array_pop($list); # извлекает послений элемент
array_unshift($list, "apple", "raspberry"); # добавляет один или несколько элементов в начало массива
array_push($list, "apple", "raspberry"); # добавляет один или несколько элементов в конец массива
$un_result = array_unique($list); # убирает повторяющиеся значения из массива
$flipped = array_flip($list3); # меняет местами ключи с их значениями в массиве

# (arsort, asort - сортирока по значениям с сохранением ключей),
# (krsort, ksort - сортировка по ключам)
# (sort, rsort - для обычных списков)

?>

<!-- работа со строками -->

<?php

$some_str = 'Hello World!  ';
$some_arr = ['apple', 'raspberry'];
echo strlen($some_str); # возвращает длину строки(количество байт)
$new_arr = explode(' ', $some_str); # сплит как в питоне
$new_str = implode(', ', $some_arr); # join как в питоне, можно использовать синоним join
$new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES); # преобразовывает специальные символы в HTML-сущности
$trimmed = trim($some_str); # strip в питоне, также ltrim, rtrim
$new_str2 = nl2br("cat\ndog"); # вставляет HTML-код разрыва строки перед каждым переводом строки
$new_str3 = strtolower('cat'); # lower
$new_str4 = strtoupper('cat'); # upper
$new_str5 = substr($some_str, 0, 5); # срез строки
$new_str6 = str_replace(' ', '', $some_str); # replace в питоне
$pos = strpos($some_str, 'e') // поиск индекса по первому вхождению символа
$firstName = 'John';
$lastName = 'Doe';
echo $firstName . ' ' . $lastName; # конкатенация строк
echo $firstName[0]; # получение байта по индексу
echo $firstName[-1];
echo $firstName[1] = 'O'; # изменение байта по индексу
?>

<!-- импорты -->

<?php

# тоже что и импорт в питоне, если файла нет будет предупреждение
include_once 'file_name.php';
include 'file_name.php'; # можно импортировать множество раз

# тоже что и импорт в питоне, если файла нет будет ошибка
require_once 'file_name.php';
require 'file_name.php'; # можно импортировать множество раз

# включение содержимого файла в строку
ob_start();
include 'file_name.php';
$res = ob_get_clean();
$res = str_replace('some_text', 'another_text', $res);
echo $res;

?>

