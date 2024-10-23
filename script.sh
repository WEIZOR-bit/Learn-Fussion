#!bin/bash
services=$(docker-compose config --services | sed 's/^/learn-fussion-develop_/')
echo "$services"

for service in $services; do
  # Задаем имя образа
  image_tag="braunbad/${service}:latest"

  # Тегируем собранный образ
 docker tag ${service} ${image_tag}

  # Пушим образ в Docker Hub
  docker push ${image_tag}
done