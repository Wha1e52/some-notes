interface User {
    id: number;
    name: string;
    age: number;
    optionalProp?: string // опциональное свойство через ?
}

const someVar: string = 'some string';
const someVar2: number = 2;
const someArr: string[] = ['a', 'b', 'c'];
const someArr2: number[] = [1, 2, 3];
const someArr3: (string|number)[] = ['a', 1, 'b', 2];

const someUser: User = {
    id: 1,
    name: 'John',
    age: 30
}

// generic
interface Box<T> {
    contents: T;
}

const boxOfString: Box<string> = {
    contents: 'hello'
}

const boxOfNumbers: Box<number[]> = {
    contents: [1, 2, 3]
}

const identity = <T>(x: T): T => x; // generic function
















