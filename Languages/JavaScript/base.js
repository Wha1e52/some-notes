'use strict' // использовать строгий режим

console.log('some text'); // принт в консоль
console.dir(); // показывает все свойства объекта
console.table([1,2,3,4,5,6,7,8,9,10]); // console.table() - показывает данные в виде таблицы

// ---------------------------------------------------------------------------------------------------------------------
// todo переменные
// типы:
    // примитивные: string, number, boolean, null, undefined, symbol;
    // ссылочный: object

// camelCase
let someVar = 10;

let someVar2;
someVar2 = 'some string';
let someVar3 = `some text, ${someVar2}`; // как f-строка в питоне

const DB_HOST = 'localhost'; // константа объявляется и присваивается одним выражением, нельзя переопределить
const countryPropertyName = 'country';
const name = 'Alex';
const age = 30;
Boolean(false) // 0, false, '', undefined, null
// преобразование типов
let xxx = 5;
xxx = String(xxx); // value + '' (конкатенация с пустой строкой)
xxx = Number(xxx);
xxx = Boolean(xxx);
let zxc = '42px';
zxc = parseInt(zxc); // 42
zxc = parseFloat('14.1asdsad'); // 14.1
// ---------------------------------------------------------------------------------------------------------------------
// todo объекты
const someObject = {a: 1, b: 'hello', c: true, d: null};
someObject.a = 2; // вернет 2
someObject['b'] = 'hello world'; // альтернативный синтаксис, лучше использовать с выражениями
someObject[countryPropertyName] = 'USA'; // через . бы не получилось
delete someObject.d; // вернет true если удаление прошло успешно

const userProfile = {
    name, // сокращенная запись тоже что и name: name (рекомендуется объявлять вначале)
    age, // сокращенная запись тоже что и age: age
    isAdmin: true
}
const userProfileCopy = Object.assign({}, userProfile); // создаст shallow копию объекта
const userProfileCopy2 = {...userProfile}; // создаст shallow копию объекта
const userProfileCopy3 = JSON.parse(JSON.stringify(userProfile)); // создаст deep копию объекта

const myCity = {
    name: 'Moscow',
    getCoords: function (){
        console.log(this.name + ': lat: 55.7558, long: 37.6173')
    }
}
myCity.getCoords()

const myCity2 = {
    name: 'Moscow',
    getCoords(){ // сокращенная запись
        console.log(this.name + ': lat: 55.7558, long: 37.6173')
    }
}
myCity2.getCoords()

// глобальные объекты
// window // окно браузера
// global; // в node.js
// globalThis; // унифицированный глобальный объект
// ---------------------------------------------------------------------------------------------------------------------
// todo json
const jsonStr = JSON.stringify({
    id: 1,
    name: 'Leanne Graham',
    username: 'Bret',
    email: '1Z8v5@example.com',
    isAdmin: true,
    address: {
        street: 'Kulas Light',
        city: 'Gwenborough',
    }
})
console.log(jsonStr)

const jsonList = JSON.parse(jsonStr)
console.log(jsonList)
// ---------------------------------------------------------------------------------------------------------------------
// todo функции

function func(){
    console.log('some text');
}

setTimeout(func, 2000); // функция будет вызвана через 2 секунды

// стрелочная функция
const func2 = (a, b) => {
    console.log(`это как f-строка ${a} + ${b} = ${a + b}`);
}
func2();

setTimeout(() => {console.log('отложенное сообщение')}, 1000)
// (a, b) => a + b; // фигурные скобки можно опустить, если в теле одно выражение (неявный возврат)
// a => {return тело} // круглые скобки можно опустить, если один параметр

function sum(a, b = 5) {
    return a + b
}
console.log(sum(1, 2));

// функциональное выражение(анонимная функция)
setTimeout(function() {console.log('отложенное сообщение')}, 1000)

const newPost = (post, addedAt) => ({...post, addedAt}) // создание нового объекта и неявный возврат
const firstPost = {id: 1, title: 'some title'}
console.log(newPost(firstPost))
// ---------------------------------------------------------------------------------------------------------------------
// todo обработка ошибок

const fnWithError = () => {
    throw new Error('some error');
}

try {
    fnWithError();
} catch (e) { // ошибка присваивается как значение пойманное в try
    console.log(e.message);
}
// ---------------------------------------------------------------------------------------------------------------------
// todo строки

const str = 'some text';
str.length
str.toLowerCase()
str.toUpperCase()
str.substring(0, 4) // вытащить подстроку с по включительно
str.charAt(4) // вытащить символ по индексу
str.indexOf('text') // вытащить индекс начала подстроки


// ---------------------------------------------------------------------------------------------------------------------
// todo массивы

const arr = [1, 2, 3, 4, 'asd', false];
const arr2 = new Array(1, 2, 3, 4, 5);
arr[0] = 'abc';
arr.push(true); // добавить элемент в конец
const removedElement = arr.pop(); // удаляет и возвращает последний элемент
const removedElement2 = arr.shift(); // удаляет и возвращает первый элемент
arr2.unshift(0); // добавить элемент в начало
console.log(arr[2]);
console.log(arr.length);
arr2.forEach(el => console.log(el * 2)); // вызывает функцию для каждого элемента массива
const newArr = arr2.map(el => el * 3); // вызывает функцию для каждого элемента массива и возвращает новый массив
const newArr2 = arr.join(', ') // join как в питоне
const sortedNewArr = newArr.sort()
arr.splice(4, 1) // удалить элемент по индексу
arr.splice(-1, 0, 'newEl') // добавить элемент по индексу, прежний элемент сместится вправо
arr.slice(1) // удалить все элементы начиная от индекса
// ---------------------------------------------------------------------------------------------------------------------
// todo деструктуризация

const userProfile2 = {
    name2: 'Alex',
    age2: 30,
    isAdmin2: true
}

const {name2, age2} = userProfile2; // распаковка и присваивание в новые переменные
const {isAdmin2} = userProfile2;

const fruits = ['apple', 'banana'];
const [fruitOne, fruitTwo] = fruits;

const userInfo = ({name2, age2}) => {
    if (age2 < 18) {
        return `User ${name2}, age ${age2}, not allowed to buy something`
    }

    return `User ${name2}, age ${age2}`
}
let someStr = userInfo(userProfile2);
// ---------------------------------------------------------------------------------------------------------------------
// todo условия

let a = 1;
let b = 2;

if (a > b) {
    console.log("a больше b");
} else if (a === b) {
    console.log("a равно b");
} else if (!userProfile2.name3) {
    console.log("имя3 не задано");
} else {
    console.log("a меньше b");
}

switch (a) {
    case 1:
        console.log('1');
        break;
    case 2:
        console.log('2');
        break;
    case 3:
        console.log('3');
        break;
    default:
        console.log('else');
}


// вместо вложенных if использовать гварды
if (user) {
    if (user.isActive) {
        if (user.age >= 18) {
            console.log('Processing user:', user.name);
        } else {
            console.log('User is underage.');
        }
    } else {
        console.log('User is not active.');
    }
} else {
    console.log('No user provided.');
}
// вот так:
function processUser(user) {
    if (!user) {
        console.log('No user provided.');
        return;
    }

    if (!user.isActive) {
        console.log('User is not active.');
        return;
    }

    if (user.age < 18) {
        console.log('User is underage.');
        return;
    }

    console.log('Processing user:', user.name);
}

// ---------------------------------------------------------------------------------------------------------------------
// todo циклы

// for
// счетчик, условие, действие. более краткая версия while
for (let i = 1900; i <= 2024; i++) {
    console.log(i);
}

// for in для объектов и массивов (обычный цикл как в питоне)
for (const key in userProfile2) { // key - свойство объекта
    console.log(key, userProfile2[key]);
}
// можно использовать вместо for in
Object.keys(userProfile2).forEach(key => {
    console.log(key, userProfile2[key])
});
Object.values(userProfile2).forEach(value => {
    console.log(value)
});

// for of перебор iterable (если при for in ключи, то тут значения), не для объектов
let myString = 'hello';
for (const letter of myString) {
    console.log(letter)
}


// while
let year = 1900;
while (year <= 2024) {
    console.log(year);
    year++;
}

// do while
year = 1900;
do {
    console.log(year);
    year++;
} while (year <= 2024);

// todo export/import

// импорт и экспорт одной переменной:
// moduleOne.js
// const myName = () => {
//     console.log('my name is Alex');
// }
// export default myName;

// moduleTwo.js
// import myName from './moduleOne';
// myName();

// импорт и экспорт нескольких переменных:
// moduleOne.js
// const one = 1
// const two = 2
// export {one, two} // рекомендуется экспортировать внизу файла

// moduleTwo.js
// import { // рекомендуется импортировать сначала внешние библиотеки, потом свои модули
//     one as oneRenamed,
//     two
// } from './moduleOne';
// console.log(oneRenamed);






























