"""

# создает и запускает контейнер из образа(даже если его нет локально, найдет его и скачает)
# :tag указание тега (latest, 1.0, etc...)
docker run image_name:tag

# запускает команду весте с контейнером
docker run image_name some_command

# создает новый контейнер из образа не запуская его
docker container create image_name

# показывает статистику по запущенным контейнерам
docker container stats

# отображение запущенных процессов контейнера
docker container top container_id/container_name

# удаляет контейнер по id/name
# (остановленные или завершенные, в случае успеха вернет id/name контейнера) можно указать несколько контейнеров
# rm(remove)
docker rm container_id/container_name
docker rm $(docker ps -aq) # удаляет все контейнеры *надо тестить

# останавливает контейнер по id/name
docker stop container_id/container_name

# запускает остановленные контейнеры по id/name
docker start container_id/container_name

# если не останавливается через stop, то через kill процесс будет остановлен моментально
docker kill container_id/container_name

# удаляет все остановленные контейнеры
docker container prune

# прикрепление контейнера к консоли
docker attach container_id/container_name

# запуск дополнительного процесса внутри уже запущенного контейнера
docker exec -it container_id/container_name process_name
docker exec -it container_id/container_name bash

# показывает информацию о контейнере по id/name
docker inspect container_id/container_name

# |, также известная как "pipe" в командной строке UNIX и Linux, используется для передачи вывода одной команды на вход другой команды
# grep в операционных системах UNIX и Linux используется для поиска строк текста, которые соответствуют определенному шаблону
docker container inspect container_id | grep IPAddress

# показывает логи контейнера по id/name
# -f подключается к контейнеру и выводит все логи(слушает что еще будет писать), чтобы не вводить 100 раз команду logs
# --tail n - показывает только последние n строк
docker logs container_id/container_name

# показывает id контейнера
hostname
# показывает ip адрес контейнера
hostname -i
________________________________________________________________________________________________________________________
todo Flags

# показывает список запущенных и остановленных контейнеров. Без -a только запущенных
# ps(process status), -a(all)
docker ps -a

# -i(--interactive) -t (--tty (Teletype)) чтобы подключить терминал к процессу контейнера
docker run -it image_name

# -d(--detach) для запуска в фоновом режиме. Чтобы мы не были подключены к выводу из процесса
docker run -d image_name

# -p(--publish) открывает порт(внешний) на компьютере и пробрасывает его на порт(внутренний) в контейнере
docker run -p 8080:80 image_name

# -v(--volume) подключение тома (если тома нет, то он будет создан)
# содержимое внутри папки контейнера будет заменено содержимым из локальной папки
docker run -v ${PWD}(путь к локальной папке):/path/to/container(путь к папке в контейнере) image_name

# -e (--env) добавление переменных окружения
docker run -d -e MY_ENV_VARIABLE=value image_name
________________________________________________________________________________________________________________________
todo Options

# --name установка имени контейнера
docker run -d --name container_name image_name

# --rm удаляет контейнер после остановки
docker run -d --rm image_name

# --entrypoint переопределяет entrypoint в Dokerfile
docker run --entrypoint command image_name

# --link определяет связь между двумя контейнерами (можно несколько link ) *устаревшая команда
# container_name(с каким контейнером устанавливаем связь)
# alias(по какому имени будет общаться приложение)
docker run --link container_name:alias image_name

# --cpus ограничение вычислительной мощности для контейнера (.5 = 50% от мощности процессора)
docker run --cpus=.5 image_name

# --memory ограничение памяти в мегабайтах для контейнера
docker run --memory=512m image_name

--mount более предпочтительный способ привязки томов чем -v
docker run --mount type=bind,source=/data/mysql,target=/var/lib/mysql image_name

"""