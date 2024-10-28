# Dockerfile
FROM openresty/openresty:alpine

# Копируем наш конфиг Nginx в контейнер
COPY ./nginx.conf /usr/local/openresty/nginx/conf/nginx.conf
RUN apk add mc

# Создаем директорию для логов
RUN mkdir -p /var/log/nginx

EXPOSE 80