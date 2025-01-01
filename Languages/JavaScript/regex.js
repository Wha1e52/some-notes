// const regex = /шаблон/флаги;
// const regex = new RegExp('шаблон', 'флаги');

/*
Флаги регулярных выражений
g – глобальный поиск (находит все совпадения).
i – регистронезависимый поиск.
m – многострочный режим.
s – позволяет точке . захватывать символ новой строки \n.
u – включает поддержку кодировки Unicode.
y – поиск на фиксированной позиции.

Основные символы и их значения
Символы для поиска:

. — любой символ, кроме новой строки.
\d — любая цифра (0-9).
\D — любой символ, кроме цифры.
\w — любая буква, цифра или _ (слово).
\W — любой символ, кроме буквы, цифры или _.
\s — пробельный символ.
\S — любой символ, кроме пробела.
^ — начало строки.
$ — конец строки.
Квантификаторы:

* — 0 или более раз.
+ — 1 или более раз.
? — 0 или 1 раз.
{n} — ровно n раз.
{n,} — не менее n раз.
{n,m} — от n до m раз.
Группы и альтернативы:

(abc) — группа символов.
| — логическое "или".
(?:abc) — группа без запоминания.
(?=abc) — положительный просмотр вперед.
(?!abc) — отрицательный просмотр вперед.

Методы работы с регулярками
Методы строки:

str.match(regex) — возвращает совпадения.
str.matchAll(regex) — возвращает все совпадения (с флагом g).
str.search(regex) — возвращает индекс первого совпадения.
str.replace(regex, replacement) — заменяет совпадения.
str.split(regex) — делит строку по совпадениям.
Методы объекта RegExp:

regex.test(str) — проверяет, есть ли совпадения (возвращает true/false).
regex.exec(str) — возвращает первое совпадение или null.
 */

const str = "Я учу JavaScript!";
const regex = /учу/;
console.log(regex.test(str));

const str2 = "Я учу JavaScript!";
const newStr = str2.replace(/JavaScript/, "JS");
console.log(newStr); // "Я учу JS!"

const str3 = "Мой номер: 123-456-7890";
const regex2 = /\d{3}-\d{3}-\d{4}/;
console.log(str3.match(regex2)); // ["123-456-7890"]

const str4 = "яблоко, банан, груша";
const result = str4.split(/,\s*/);
console.log(result); // ["яблоко", "банан", "груша"]


// Примеры сложных задач
// 1. Валидация email
// javascript

const email = "example@mail.com";
const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
console.log(emailRegex.test(email)); // true

const str5 = "Я учу JavaScript каждый день";
const result2 = str5.replace(/\s+/g, ",");
console.log(result2); // "Я,учу,JavaScript,каждый,день"

const phone = "+7 (123) 456-78-90";
const phoneRegex = /^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/;
console.log(phoneRegex.test(phone)); // true