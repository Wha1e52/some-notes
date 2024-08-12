"""
pwd - Print Working Directory

ls - List information about file(s). -la - list all files

cd — Change Directory
~/ - home directory

ctrl + l - clear

touch - create an empty file

rm - Remove file. с флагом -i, будет предупреждение об удалении. -r для рекурсивного удаления всех файлов в директории вместе с ней.

mv - Move file or directories. передаем имя файла и директорию для перемещения. если указать 2 имени файла, 1й будете переименован во 2й
     с флагом -i, будет предупреждение о перезаписи. с флагом -t и указанием директории можно перемещать несколько файлов

mkdir - Create new folder
rmdir - Remove directory

ctrl + w - delete the last word of the line
ctrl + a - to the beginning of the line
ctrl + e - to the end of the line

cp - Copy one or more files to another location
     с флагом -i, будет предупреждение о перезаписи
     при копировании директорий нужно использовать -r для рекурсивного копирования всех файлов

cat - Concatenate and print (display) the content of files

less - Display output
head - Output the first part of file
tail - Output the last part of a file

chmod +x install.bin - make file executable.  ./install.bin - run file

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

grep - Search by pattern.
      some output | grep pattern

"""