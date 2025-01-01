/*
1. Async/await - это синтаксическая надстройка над промисами
2. await синтаксис возможен только внутри async функций
3. async функция всегда возвращает Promise
*/

async function asyncFn() {
    return 'some text';
}

const asyncFn2 = async () => {

}

asyncFn()
    .then(value => console.log(value))
    .catch(error => console.log(error.message))


const timerPromise = () => new Promise((resolve, reject) =>
    setTimeout(() => resolve(), 2000)
)

const asyncFn3 = async () => {
    console.log('timer start');
    const startTime = performance.now();
    await timerPromise();
    const endTime = performance.now();
    console.log('timer ended', endTime - startTime);
}

const getData = async (url) => {
    const res = await fetch(url)
    return await res.json()
}

try {
    const data = await getData('https://'); // await доступна только В асинхронных функциях и консоли браузера
    console.log(data)
} catch (error) {
    console.log(error.message)
}


