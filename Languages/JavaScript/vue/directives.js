/*

// v-on: / @
v-on:input="changeName" // (v-on) повесить событие, (:input) событие, (="changeName") функция отработки в methods
@input="changeName"

// v-bind / :
<a v-bind:href="url">some link</a> // (v-bind) привязать значение к атрибуту, (:href) атрибут, (="url") переменная в data
<a :href="url">some link</a>

// v-html
<h2 v-html="link"></h2> // (v-html) рендерим html, (="link") переменная в data

// v-model // two-way binding = (@input="inputValue = $event.target.value" :value="inputValue")
есть еще модификатор (v-model.lazy) // изменения применятся после снятия фокуса
<input type="text" v-model="inputValue">

// v-text
<h1 v-text="name"></h1> // тоже что и <h1>{{ name }}</h1>

// v-once
<h1 v-once>{{ name }}</h1> // отработает 1 раз и больше изменять не будет, даже если изменим data

// v-pre
<h1 v-pre>{{ name }}</h1> // выводит html как есть, без компиляции

// условные директивы
v-if="someCondition"
v-else-if="someCondition"
v-else="someCondition"

v-show // не удаляет из dom, просто ставит display: none

// цикл v-for
<li v-for="person in people">{{ person }}</li>
// В Vue.js разницы между in и of в v-for нет, оба работают одинаково
<li v-for="(person, index) in people">{{ index + 1 }} {{ person }}</li>
<li v-for="(person, index) of people">{{ index + 1 }} {{ person.name }}</li>
<li v-for="(value, key, index) in people">{{ index }} <b>{{ key }}</b> {{ value }}</li>
для циклов нужно использовать v-bind:key для уникальности идентификаторов

// v-clock
<div v-clock>
<style>
    [v-clock] {
        display: none; // убирает дергание до загрузки
    }
</style>




 */