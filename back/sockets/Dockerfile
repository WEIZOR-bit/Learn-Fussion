
FROM node:18-alpine
EXPOSE 3000

# Create app directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

COPY src /usr/src/app

RUN npm install
CMD ["npm", "start"]
