// todo классы и прототипы

class Comment {
    constructor(text) {
        this.text = text;
        this.votesQty = 0;
    }

    upvote() {
        this.votesQty += 1;
    }

    static mergeText(text1, text2) { // не доступен экземплярам
        return `${text1} ${text2}`
    }

}

const firstComment = new Comment('some text');
firstComment.upvote();
console.log(firstComment.votesQty);
console.log(firstComment instanceof Comment);
console.log(firstComment.hasOwnProperty('text')); // проверка на наличие свойства
console.log(firstComment.hasOwnProperty('date')); // false
console.log(Comment.mergeText('some', 'text'));

class NumbersArray extends Array { // наследование
    sum() {
        return this.reduce((el, acc) => acc += el, 0);
    }
}

const arr = new NumbersArray(1, 2, 3, 4, 5);
console.log(arr.sum());