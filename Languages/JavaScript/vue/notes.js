/*

// создание приложения
const app = {
    props: ['someAttribute'], // массив параметров которые ожидаем. Дальше атрибут добавляется в data и доступен через this.
    props: { // в виде объекта с валидацией
        modelValue: String, // зарезервированное имя для получения модели(v-model) // можно получать кастомное имя через v-model:name=...
        someAttribute: {
            type: String,
            required: true,
            default: 'some default value',
            validator(value) {
                return value.length > 5 // возвращаем true or false
            }
        },
        someAttribute2: Number,
        someAttribute3: Boolean,
    },
    emits: ['some-event', 'some-event2'], // массив событий которые эмитим наверх (для других разработчиков)
    emits: { // в виде объекта с валидацией
        'some-event'(num) {
            if (num > 10) {
                return true
            }
            console.warn(no data in some-event emit)
            return false
        },
        'some-event2': null,
    },
    provide() { // шарим данные в другие компоненты
        return {
            someKey: 'some value',
            someKey2: 'some value',
        }
    },
    inject: ['someKey'] // вытаскиваем данные данные из provide (в других компонентах)
    data() {
        return {
            name: 'John'
            age: 18
        }
    },
    components: {
      'some-component': someComponent(импортнутый) // локальная регистрация
      someComponent: someComponent // либо
      someComponent // либо
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
v-model.trim="someName" // сама обрежет пробелы в данных
v-model.number="someName" // приведение к числу
submit.prevent

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

// props свойство которое можем шарить между компонентами

// this.$emit('some-action', someData, someData2) вызываем в каком-нибудь методе (передаем в родительский компонент)
@some-action="someFunction" слушаем в родительском компоненте
someFunction(data, data2) {
 // do something
 console.log(data) // те someData
}

// <slot /> пишем в шаблоне компонента для получения данных из тега
// может быть именным name="someName" и чтобы передавать в именной нужно обернуть в тег <template v-slot:someName><h1>123</h1></template>
<some-component>TEXT</some-component> // в родительском компоненте
<some-component>
    <template v-slot:someName>
        <h1>123</h1>
    </template>
</some-component>

<button> // в компоненте
    <slot /> // TEXT
</button>

// $slots - хранит переданные слоты
// если в компоненте у слота забиндить данные <slot :name1="1" :name2="2" />, то в родительском можно иъ достать
<template #default="{ name1, name2 }">
    <h1>123</h1>
</template>

// <style scoped> // scoped добавляет стили только к данному компоненту

// динамические компоненты
<component :is="'componentName'"></component>
имя будет удобно высчитывать в computed и сюда подставлять

// <keep-alive></keep-alive> // сохраняет состояние компонента и не перерисовывает его
<keep-alive>
    <component :is="'componentName'"></component>
</keep-alive>

// расширенный функционал computed (по-умолчанию обычные ф-ции это гетеры)
someName: {
    get() {
        return ''
    },
    set(value) {
        console.log(value)
    }
}






*/
