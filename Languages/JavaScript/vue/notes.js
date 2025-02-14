/*

// создание приложения
const app = {
    data() {
        return {
            name: 'John'
            age: 18
        }
    },
    methods: {
        changeName() {
            this.name = 'Jane'
        },
        changeAge(event) {
            this.age = event.target.value
        }
    }
}
const v = Vue.createApp(app)
v.mount('#app') // id в html, блок где будет рендериться приложение

// интерполяция {{ }}
выводим данные в шаблон (главное правило - чтобы значение могло быть приведено к строке) под капотом JSON.stringify
не можем передавать в значения в атрибуты, для этого v-bind
<h1>Hello {{ name }}</h1>
<h1>Age {{ (age + 10) * 2 }}</h1> // возможны простые выражения

// v-on: / @
v-on:input="changeName" // (v-on) повесить событие, (:input) событие, (="changeName") функция отработки в methods
@input="changeName"

// v-bind / :
<a v-bind:href="url">some link</a> // (v-bind) привязать значение к атрибуту, (:href) атрибут, (="url") переменная в data
<a :href="url">some link</a>

// v-html
<h2 v-html="link"></h2> // (v-html) рендерим html, (="link") переменная в data

// $event - если нужен ивент, можно передать
<button v-on:click="increaseCounter(10, $event)">Увеличить</button>

// v-model // two-way binding = (@input="inputValue = $event.target.value" :value="inputValue")
есть еще модификатор (v-model.lazy) // изменения применятся после снятия фокуса
<input type="text" v-model="inputValue">

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

ref
<h2 ref="heading">{{ title }}</h2>
...
this.$refs.heading

// модификаторы (через точку)
<input type="text" v-on:keypress.enter="someFunction">












*/
