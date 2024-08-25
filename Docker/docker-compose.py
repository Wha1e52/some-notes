"""
# запуск контейнеров на основе docker-compose.yml
в фоновом режиме(-d)
docker-compose up -d

# остановка всех контейнеров и их удаление
docker-compose down

# остановка всех контейнеров, не удаляя их
docker-compose stop

# запуск контейнеров с пересозданием образов
docker-compose up -d --build

# -f если имя docker-compose отличается от docker-compose.yml, указываем явно какое. При down тоже указываем -f
docker-compose up -f docker-compose-dev.yml -d

# поднять еще n-контейнеров
docker-compose scale container_name=number_of_containers *не работает?
docker-compose up -d --scale service_name=number_of_containers

# покажет контейнеры за которые отвечает docker-compose
docker-compose ps

# общий пул логов
docker-compose logs
















"""
