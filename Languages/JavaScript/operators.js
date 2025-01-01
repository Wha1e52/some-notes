<!-- Операторы -->

let x = true
let y = false
let i, j
let someStr = '1'
let someNumber = 0;
let someNumber2

// arithmetic
1 + 2;
1 - 2;
2 * 2;
4 / 2;

someNumber2 = +someStr; // конвертация в int

// assignment
let var1 = 1; // = присвоение

// комбинированые операторы такие же как в питоне
var1 += 1; // var1 = var1 + 1
var1 -= 1;
var1 *= 1;
var1 /= 1;

// increment/decrement операторы

someNumber++; // сначала вернет значние, а потом увеличит на 1
++someNumber; // сначала увеличит на 1, а потом вернет значние
someNumber--; // сначала вернет значние, а потом уменьшит на 1
--someNumber; // сначала уменьшит на 1, а потом вернет значние

// string operators
let str1 = 'hello, ';
let str2 = 'world';

let str3 = str1 + str2; // + конкатенация строк. При конкатенации все приводится к строке

// comparison operators
x = 1;
y = 2;

x === y;
x !== y;
x > y;
x < y;
x >= y;
x <= y;

// logical operators
// !!!возвращают не true или false, а значение одного из операндов!!!
x = true;
y = false;

x && y; // and
x || y; // or
!x; // not
!!x; // not not двойное отрицание (по сути просто преобразование в boolean)

let name33 = 'Alex';
const name22 = name33 || 'default name'; // что-то типа null-coalescing
name33 && console.log('выполнено'); // трюк для выполнения команды только если name33 тру

// оператор разделения на свойства
const button = {width: 10, text: 'buy'};
const redButton = {...button, color: 'red', }; // ... порядок имеет значение, т.к последний перепишет предыдущий если есть дубликаты


// ternary operator:
let color = 'red';
// условие ? если истина : если ложь
console.log(color === 'green' ? 'go' : 'stop');



// текстовые операторы:
    // typeof 10
    // instanceof obj
    // new Obj()
    // delete obj.a