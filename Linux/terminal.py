"""
// Нажав на Tab - автодополнение слова

// если вызывать команду в терминале в конце с &, то команда будет выполняться в фоне

// Специальные символы
.   - current directory
..  - parent directory
~   - home directory
*   - any number of characters
?   - any single character

pwd - Print Working Directory

ls - List information about file(s). -lah - List All files in Human readable format (можно передать директорию)

man some_command - manual (q - exit)

clear - Clear the screen

exit - Exit the shell

cd путь    - Change Directory
mkdir путь - Create new folder
rmdir путь - Remove directory. -p - create parent directories if they don't exist
touch путь - create an empty file
rm путь - Remove file. с флагом -i, будет предупреждение об удалении. -r для рекурсивного удаления всех файлов в директории вместе с ней. -rf - удалить директорию вместе с содержимым без предупреждений
mv путь1 путь2 - Move file or directories. передаем имя файла и директорию для перемещения. если указать 2 имени файла, 1й будете переименован во 2й
     с флагом -i, будет предупреждение о перезаписи. с флагом -t и указанием директории можно перемещать несколько файлов
cp путь1 путь2 - Copy one or more files to another location
     с флагом -i, будет предупреждение о перезаписи
     при копировании директорий нужно использовать -r для рекурсивного копирования всех файлов


ctrl + l - clear
ctrl + w - delete the last word of the line
ctrl + a - to the beginning of the line
ctrl + e - to the end of the line

ctrl + shift + c - copy the line
ctrl + shift + v - paste

ctrl + c - прервать выполнение
ctrl + z - приостановить выполнение.
fg - продолжить в foreground
bg - продолжить в background

ctrl + shift + t - открыть новый терминал
ctrl + shift + w - закрыть текущий терминал
alt + <0-9> - переключение между терминалами

// ввод и вывод
программа < file - ввод из файла
программа > file - вывод в файл
программа >> file - вывод в файл (добавить)
программа 2> file - вывод ошибок в файл
программа 2>> file - вывод ошибок в файл (добавить)
программа1 | программа2 | ... | программа n - вывод программы1 в программу2 ... (pipe)


cat путь - Concatenate and print (display) the content of files
cat путь > file.txt - redirect output to file
less путь - Display output (q - exit)
head - Output the first part of file
tail - Output the last part of a file
nano путь - edit file in Text editor nano

useradd username - add user. -m - create home directory
passwd username - set password
userdel username - delete user. -r - delete user and home directory
groupadd groupname - add group
getent group - list groups
usermod -a -G groupname username - добавляет пользователя в указанную группу без удаления из других групп
gpasswd --delete username groupname - delete user from group
chown username:groupname filename - change file's owner

find - Search for files.
    -name/iname filename - search for filename.
    -type d - search for directories.
    -size +1M - search for files larger than 1 megabyte.
    -empty - search for empty files.

find папка -name "*.jpg" - без папки будет поиск в текущей директории

grep - Search by pattern.
      some output | grep pattern

grep "pattern" file - найти строку в файле
grep -c "pattern" file - подсчитать количество вхождений строки
grep -r "pattern" папка - рекурсивный поиск во всех подпапках

jobs - посмотреть список запущенных программ
ps - посмотреть список запущенных процессов
top - посмотреть список запущенных процессов в реальном времени
top -u username - посмотреть список запущенных процессов пользователя
kill process_id - остановить запущенную программу
kill -9 process_id - остановить запущенную программу forcefully

free -g - информация о оперативной памяти
nproc - количество процессоров
lscpu - информация о процессоре


"""