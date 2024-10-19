# Используем официальный образ Alpine
FROM alpine:3.14

# Устанавливаем необходимые пакеты
RUN apk add --no-cache curl bash

# Устанавливаем MinIO Server
RUN curl -O https://dl.min.io/server/minio/release/linux-amd64/minio \
    && chmod +x minio \
    && mv minio /usr/bin/minio

# Устанавливаем MinIO Client (mc)
RUN curl -O https://dl.min.io/client/mc/release/linux-amd64/mc \
    && chmod +x mc \
    && mv mc /usr/bin/mc

# Копируем скрипт настройки
COPY setup.sh /usr/bin/setup.sh
RUN chmod +x /usr/bin/setup.sh

# Открываем порты для MinIO
EXPOSE 9000
EXPOSE 9001

# Запуск контейнера
CMD ["sh", "-c", "minio server /data --console-address :9001"]