<?php
/*

Storage::disk('s3')->get('file.jpg');

get('file.jpg') // Извлекает файл file.jpg.
put('file.jpg', $contentsOrStream) // Помещает содержимое в файл file.jpg.
putFile('myDir', $file) // Помещает содержимое указанного файла (в виде экземпляра класса Illuminate\Http\File или Illuminate\Http\UploadedFile) в каталог myDir, но с передачей управления всей потоковой обработкой и именованием файла на фреймворк Laravel.
exists('file.jpg') // Возвращает логическое значение, указывающее, существует ли file.jpg.
getVisibility('myPath') // Получает статус видимости для указанного пути — public (открытый) или private (закрытый).
setVisibility('myPath') // Задает статус видимости для указанного пути — public или private.
copy('file.jpg', 'newfile.jpg') // Копирует file.jpg в файл newfile.jpg.
move('file.jpg', 'newfile.jpg') // Перемещает file.jpg в файл newfile.jpg.
prepend('my.log', 'log text') // Добавляет содержимое в начале файла my.log.
append('my.log', 'log text') // Добавляет содержимое в конце my.log.
delete('file.jpg') // Удаляет file.jpg.
size('file.jpg') // Возвращает размер файла file.jpg в байтах.
lastModified('file.jpg') // Возвращает временную метку Unix для момента последнего изменения file.jpg.
files('myDir') // Возвращает массив имен файлов, расположенных в каталоге myDir.
allFiles('myDir') // Возвращает массив имен файлов, расположенных в myDir и всех подкаталогах.
directories('myDir') // Возвращает массив имен каталогов, расположенных в myDir.
Локальные и облачные файловые менеджеры 405
allDirectories('myDir') // Возвращает массив имен каталогов, расположенных в каталоге myDir и во всех подкаталогах.
makeDirectory('myDir') // Создает новый каталог.
deleteDirectory('myDir') // Удаляет myDir.
readStream('my.log') // Получает ресурс для чтения my.log.
writeStream('my.log', $resource) // Записывает данные в новый файл (my.log) с использованием потока.

// Типичный способ реализации загрузки пользователями файлов на сервер
...
class DogController
{
    public function updatePicture(Request $request, Dog $dog)
    {
        Storage::put(
            "dogs/{$dog->id}",
            file_get_contents($request->file('picture')->getRealPath())
        );
    }
}

// Более сложный способ выгрузки файлов на сервер с использованием библиотеки Intervention
...
class DogController
{
    public function updatePicture(Request $request, Dog $dog)
    {
        $original = $request->file('picture');
        // Изменение размера изображения до максимальной ширины 150
        $image = Image::make($original)->resize(150, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 75);

        Storage::put(
            "dogs/thumbs/{$dog->id}",
            $image->getEncoded()
        );
    }

// Простейшая реализация скачивания файлов
public function downloadMyFile()
{
    return Storage::download('my-file.pdf');
}

















*/