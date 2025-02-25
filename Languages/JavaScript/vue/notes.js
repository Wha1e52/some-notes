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
    },
    computed: {

    },
    watch: {

    }
}
const v = Vue.createApp(app)
v.mount('#app') // id в html, блок где будет рендериться приложение

// интерполяция {{ }}
выводим данные в шаблон (главное правило - чтобы значение могло быть приведено к строке) под капотом JSON.stringify
не можем передавать в значения в атрибуты, для этого v-bind
<h1>Hello {{ name }}</h1>
<h1>Age {{ (age + 10) * 2 }}</h1> // возможны простые выражения
можем внутри вызывать методы, если они возвращают строку

// $event - если нужен ивент, можно передать
<button v-on:click="increaseCounter(10, $event)">Увеличить</button>

// ref
<input ref="someName">
...
в методе
this.$refs.someName.value // можно достать значение

// модификаторы (через точку)
<input type="text" v-on:keypress.enter="someFunction">
через .stop/prevent можно прекратить действие по умолчанию?

// computed
должны что-то возвращать (и в идеале зависеть от пременных в data)
в шаблоне не вызываются напрямую вот так - someMethod(), используем без скобок как с переменными

// watch
следит за изменениями переменных
название метода должно совпадать с именем переменной, принимает новое значение

// динамическое изменение стилей
<h1 :style="{
    color: someVarInData.length > 10 ? 'red' : 'black',
    fontSize: someVarInData.length < 10 ? '1em' : '2em'
}">{{ title }}</h1>
в качестве ключа - название свойства
в качестве значения - условие
если css свойство состоит из 2х и более слов - используем camelCase

// динамическое изменение классов
1
<h1 :class="someVarInData.length > 10 ? 'primary' : 'bold">{{ title }}</h1>

2
<h1 :class="{
    'primary': someVarInData.length > 10,
    'bold': someVarInData.length < 10
}">{{ title }}</h1>
в качестве ключа - название класса
в качестве значения - условие

3
<h1 :class="['bold', {'primary': someVarInData.length > 10}]">{{ title }}</h1>
простой элемент - добавляет класс всегда и без условий
объект с ключом и условием работает как в примере 2

// фильтрацию по массивам лучше сделать через computed и уже в цикле использовать этот метод

// несколько методов на событие
<button @click="someFunction, someFunction2">Click</button>























*/
