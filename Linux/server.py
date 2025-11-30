"""
ssh login@address -p port - вход по ssh

ssh-keygen - генерация ключа
ssh-add - сообщить системе о ключе

cat ~/.ssh/id_rsa.pub - просмотр ключа

nano ~/.ssh/authorized_keys - редактирование ключей (на сервере). Если там лежит наш ключ, то не потребуется пароль при входе.

scp -P port login@address:путь1 путь2 - копирование сервера(путь1) на локальную машину(путь2)
scp -P port путь1 login@address:путь2 - копирование с локальной машины(путь1) на сервер(путь2)

sudo apt-get install программа - установка программы через терминал
sudo apt-get remove программа - удаление программы через терминал
sudo apt-get update - обновление ссылок на пакеты
sudo apt-get upgrade - обновление пакетов

sudo apt-get install --only-upgrade программа - обновление программы через терминал


"""