


const myPromise = new Promise((resolve, reject) => {});

myPromise
    .then(value => {

    })
    .catch(error => {

    })
    // .finally()

fetch('https://')
    .then(response => response.json()) // метод .json тоже возвращает промис
    .then(json => console.log(json))
    .catch(error => console.error(error))


const getData = (url) =>
    new Promise((resolve, reject) =>
    fetch(url)
        .then(response => response.json())
        .then(json => resolve(json))
        .catch(error => reject(error))
    )

getData('https://')
    .then(data => console.log(data))
    .catch(error => console.log(error.message))