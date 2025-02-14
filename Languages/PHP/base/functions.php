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


    # void - ничего не возвращаем
    # mixed - возвращаем различные типы
    # some_type|some_type2|some_type3 - возвращаем some_type или some_type2 или some_type3
    # ?some_type - может возвращать some_type или null

    function my_func(int|float $arg1, $arg2, string $arg4 = 'default value', $arg3 = 2): void {
        echo "Hello World, $arg1, $arg2, $arg3, $arg4";
    }

    my_func(1, 2, arg3: 3,);

    # *args в питоне
    function my_func2(...$args): ?array {
        return $args;
    }
    $res = my_func2(1, 2, 3, 4, 5);
    $some_arr = [4, 5, 1, 6]; // если будет ассоциативный массив, то распаковка будет с именными аргументами, несмотря на порядок в массиве
    $res = my_func2(...$some_arr); # распаковка массива в аргументы функции

    $some_var = 1;
    # изменит some_var, поскольку по ссылке &, тоже что и global внутри функции в питоне
    function my_func3(&$arg1): void {
        $arg1 += 10;
    }
    my_func3($some_var);

    # статическая переменная
    function get_value() {
        static $value = null; // статическая переменная используется как кэш и при повторном вызове данные в ней уже хранятся
        if ($value === null) {
            $value = some_expansive_processing();
        }
        return $value;
    }
    function some_expansive_processing() {
        sleep(2);
        return 'some value';
    }

    # variable function
    function some_func(...$values) {
        return array_sum($values);
    }
    $x = 'some_func';
    if (is_callable($x)) {
        echo $x(1, 2);
    }


    # anonymous function
    $x = 1;
    $some_func = function ($arg1, $arg2) use ($x) { // use для доступа к parent scope переменной(копия)
        echo $x;
        return $arg1 + $arg2;
    }; // нужна ; в конце

    echo $some_func(1, 2);

    # callback functions
    function foo ($arg1) {
        return $arg1 * $arg1;
    };
    $x = function ($arg1) {
        return $arg1 * $arg1;
    };
    $array2 = array_map('foo', [1, 2, 3]);
    $array2 = array_map($x, [1, 2, 3]);
    $array2 = array_map(function ($arg1) {return $arg1 * $arg1;}, [1, 2, 3]);

    # arrow functions
    $x = 2; // можно получить прямой доступ к parent scope переменной
    $array2 = array_map(fn ($arg1) => $arg1 * $arg1 * $x, [1, 2, 3]); # сокращенная запись (прям лямбда в питоне) одно выражение
