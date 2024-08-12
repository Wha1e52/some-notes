<!-- Комментарии -->
<?php
// однострочный комментарий
# тоже однострочный комментарий
/* многострочный комментарий */
?>

<?php
echo 'hello'; # обычный принт, можно использовать print вместо echo
?>

<?= '<p>hello</p>' ?> == <?php echo '<p>hello</p>';?>

<!-- Переменные -->
<?php

$var = 'hello world';
$var2 = "It's a cat. $var";
$var3 = <<<HERE
It's a cat. $var. "some str".
HERE; # аналог множественных f-строк питона
$var4 = <<<'HERE'
It's a cat. "some str".
HERE; # аналог множественных обычных строк питона
const TITLE = 'my title'; # константа
define("SOMECONSTANT", "Hello world."); # константа
echo TITLE; # вывод констант без $
?>

<!-- Типы данных -->
<?php
$var_bool = true | false;
$var_int = 12;
$var_float = 3.14;
$var_string = 'hello world';
$var_null = null;
$list = ['cat', 2, 3.1, 'dog', 'bird'];
$dict = ['title' => 'my cat', 'price' => 50, 'description' => 'some description']; # тоже считается array

?>
<!-- приведение типов данных -->
<?php
var_dump((int)'123');
var_dump((float)123);
var_dump((string)123);
var_dump((0.1 * 10 + 0.2 * 10) / 10); # как избежать проблем плавающей точки 0.200000004
?>

<!-- Полезные функции -->
<?php
$some_var = 123;
$some_list = array('cat', 'dog', 'bird');
var_dump($some_var); # показывает что лежит в переменной и какого она типа
error_reporting(-1); # выводит лог ошибок
echo gettype($some_var); # показывает какого типа переменная
unset($some_var); # стирает переменную из памяти
print_r($some_list); # выводит элементы массива, менее детально чем var_dump
phpinfo(); # вывод информации по пхп
$p_hash = password_hash('password', PASSWORD_DEFAULT); # получить хеш пароля
$is_verified =  password_verify('password', $p_hash) # сверить хеш и пароль
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

<!-- Операторы -->
<?php

echo 1 + 2;
echo 1 - 2;
echo 2 * 2;
echo 4 / 2;
echo 4 % 2; # деление по модулю
echo 2 ** 3; # возведение в степень
$var = 1; # = присвоение
$var2 = &$var; # & присвоение по ссылке (не создается новая ячейка памяти, работаем с указателем)
echo $var++; # сначала вернет значние, а потом увеличит на 1
echo ++$var; # сначала увеличит на 1, а потом вернет значние
echo $var--; # сначала вернет значние, а потом уменьшит на 1
echo --$var; # сначала уменьшит на 1, а потом вернет значние
$str1 = 'hello, ';
$str2 = 'world';
echo $str1 . $str2; # . конкатенация строк
$var += 1; # комбинированые операторы такие же как в питоне
$str1 .= $str2;
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

# match-case в питоне
$a = 5;
# не забудь break
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

# всегда должно что-то возвращаться
# строгое сравнение ===
$food = 'cake';
$return_value = match ($food) {
    'apple' => 'На столе лежит яблоко',
    'banana' => 'На столе лежит банан',
    'cake' => 'На столе стоит торт',
    default => 'else',
};

?>
<!-- Тернарный оператор -->

<?php

$var = null;

# условие ? если да : если нет
echo $var == 'green' ? 'go' : 'stop';
# если истина, то выведет var, иначе выведет значение после ?:
echo $var ?: 'stop';

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

# for
# счетчик, условие, действие. более краткая версия while
for ($i = 1900; $i <= 2024; $i++) {
    echo $i . "<br>";
}

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

# для изменения значений во время цикла нужно приписать & (foreach ($some_list3 as &$value))
# и после цикла уничтожить переменную unset($value);

# break, continue такие же как в питоне
?>

<!-- работа с массивами array -->
<?php

$list = ['cat', 'dog', 'bird', 'cat'];
print_r($list); # выводит элементы массива, менее детально чем var_dump
echo $list[0]; # получаем элемент по индексу
$list2 = [2 => 'cat', 'dog', 'bird']; # указываем с какого идекса начать индексацию, либо указываем явно для каждого
$list3 = ['title' => 'my cat', 'price' => 50, 'description' => 'some description'];
$list[] = 'whale'; # добавление 1 нового элемента в конец
echo count($list); # length в пайтон
echo count($list2, COUNT_RECURSIVE); # рекурсивно посчитать все, в том числе и вложеные элементы. для многомерных
print_r(array_count_values($list)); # посчитать кол-во каждого элемента (как каунтер в питоне)
echo array_key_exists('first', $list); # проверка на присутвие ключа в массиве
echo in_array('second', $list); # проверка на присутвие значения в массиве
$key_list3 = array_keys($list3); # возвращает только ключи
$value_list3 = array_values($list3); # возвращает только значения
$merged_list = array_merge($list, $list3); # объединение массивов (строковые ключи при одинаковых - перезаписываются)
$merged_list2 = $list + $list3; # объединение массивов (одинаковые ключи не добавятся из второго массива)
$random = array_rand($merged_list, 2); # получить рандомный элемент или несколько. вернет ключи
$rev_arr = array_reverse($merged_list); # перевернуть массив в обратном порядке
$key = array_search('green', $list3); #  поиск первого найденного элемента, возвращает ключ
$animal = array_shift($list); # извлекает первый элемент
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
$new_str6 = str_replace(' ', '', $some_str) # replace в питоне


?>


<!-- функции-->

<?php

#подсказки типов не только подсказывают, но еще и приводят значение к этому типу!!
/**
 * Some description.
 * @param int $arg1
 * @param int $arg2
 * @param string $arg4
 * @param int $arg3
 * @return void
 */
function my_func(int $arg1, $arg2, $arg4 = 'default value', $arg3 = 2): void
{
    echo "Hello World, $arg1, $arg2, $arg3, $arg4";
}

my_func(1, 2, arg3: 3,);



# *args в питоне
function my_func2(...$args): array
{
    return $args;
}
$res = my_func2(1, 2, 3, 4, 5);


$some_var = 1;
# изменит some_var, поскольку по сыылке &, тоже что и global
function my_func3(&$arg1)
{
    $arg1 += 10;
}
my_func3($some_var);
?>

<!-- импорты -->

<?php

# тоже что и импорт в питоне, если файла нет будет предупреждение
include_once 'file_name.php';
include 'file_name.php'; # можно импортировать множество раз

# тоже что и импорт в питоне, если файла нет будет ошибка
require_once 'file_name.php';
require 'file_name.php'; # можно импортировать множество раз


?>