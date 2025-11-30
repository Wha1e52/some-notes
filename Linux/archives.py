"""
// флаги tar:
-z → использовать gzip
-j → использовать bzip
-c → создать архив
-v → показывать файлы
-f → следующее слово — имя архива
-x → распаковать

// распаковка
unzip archive.zip - распаковать архив
gunzip archive.gz - распаковать архив и удалить исходный архив
tar -xvf archive.tar - распаковать архив
tar -xzvf archive.tar.gz - распаковать архив
bunzip2 archive.bz2 - распаковать архив

// создание архива
zip archive.zip file1 file2 - создать архив
gzip file - создать архив и удалить исходный файл
tar -cvf archive.tar file1 file2 - создать архив без сжатия
gzip archive.tar - создать архив и удалить исходный фай
tar -zcvf archive.tar.gz file1 file2 - создать архив с сжатием
bzip2 file - создать архив


"""