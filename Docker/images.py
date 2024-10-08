"""
# показывает список локальных образов
docker images

# удаляет образ по image_name (перед удалением, нужно остановить и удалить все связанные с ним контейнеры)
docker rmi image_name

# собирает образ на основе Dockerfile в указанном каталоге(.)
docker build .

# удаляет образ
docker image rm image_id

# удаляет все образы
# -a, за исключением тех, для которых есть работающие контейнеры
docker image prune -a

# посмотреть информацию о слоях в образе
docker history image_name

# посмотреть os образа
run image_name cat /etc/*rel*

# переименовать образ
docker tag image_name/image_id new_image_name:sometag
________________________________________________________________________________________________________________________
todo Flags

# -t(добавление имени и тега для образа, если тег не указан, то будет использован latest)
# -f если имя Dockerfile отличается от Dockerfile, указываем явно какое.
docker build . -t image_name -f Dockerfile-dev
________________________________________________________________________________________________________________________
todo Options

# --target для выбора alias указанного в Dockerfile(при мультибилде)
docker build -t image_name . -f Dockerfile-dev --target dev(устанавливается как alias в Dockerfile)
________________________________________________________________________________________________________________________


"""