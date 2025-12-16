/*

package main - In Go, code executed as an application must be in a main package.

go mod init <module_name> - инициализация модуля
go run . - запуск программы
go help - получение справки
go mod tidy - to synchronize the module's dependencies, adding those required by the code, but not yet tracked in the module
go build - to compile the code into an executable
go list -f '{{.Target}}' - discover the install path

import "module_name" - импорт библиотеки

import "fmt"
fmt.Println("Hello, World!") - вывод строки

func main() - основная функция, которая запускается при запуске программы

              param type | return type
                   |        |
func Hello(name string) string { - Название с заглавной - публичная функция, которая может быть вызвана из других модулей
    message := fmt.Sprintf("Hi, %v. Welcome!", name)
    return message
}

:= - operator is a shortcut for declaring and initializing a variable in one line (Go uses the value on the right to determine the variable's type).

Taking the long way, you might have written this as:
var message string
message = fmt.Sprintf("Hi, %v. Welcome!", name)

go mod edit -replace example.com/greetings=../greetings - to redirect Go tools from its module path (where the module isn't) to the local directory (where it is).


slices (как массивы в питоне или пхп, только с данными одного типа?):

letters := []string{"a", "b", "c", "d"}

The length and capacity of a slice can be inspected using the built-in len and cap functions.

len(s) == 5
cap(s) == 5

// Обработка ошибок

import (
    "errors"
)

func Hello(name string) (string, error) {
    if name == "" {
        return name, errors.New("empty name")
    }
    message := fmt.Sprintf(randomFormat(), name)
    return message, nil
}

message, err := greetings.Hello("")
if err != nil {
    log.Fatal(err)
}

// рандом

import (
    "math/rand"
)

rand.Intn(10) - возвращает случайное число от 0 до 9

// хеш-таблица - In Go, you initialize a map with the following syntax:
make(map[key-type]value-type)
m = make(map[string]int)
delete(m, "route") // The delete function doesn’t return anything, and will do nothing if the specified key doesn’t exist.

// тесты
- Ending a file's name with _test.go tells the go test command that this file contains test functions.
- Test function names have the form TestName, where Name says something about the specific test.
    Also, test functions take a pointer to the testing package's testing.T type as a parameter.
    You use this parameter's methods for reporting and logging from your test.

go test - запуск тестов















*/