pipeline {
    agent any
    environment {
        DOCKER_COMPOSE = 'docker-compose.yml'  // Путь к файлу docker-compose.yml
    }
    stages {
        stage('Checkout') {
            steps {
                // Получение кода из ветки develop
                git branch: 'develop', url: 'https://github.com/WEIZOR-bit/Learn-Fussion.git'
            }
        }
        
        stage('Build all services') {
            steps {
                // Сборка всех сервисов, определённых в docker-compose.yml
                sh 'docker-compose -f $DOCKER_COMPOSE build'
            }
        }

        stage('Start all services') {
            steps {
                // Запуск всех сервисов в фоновом режиме
                sh 'docker-compose -f $DOCKER_COMPOSE up -d'
            }
        }

        stage('Run health checks') {
            steps {
                // Проверка состояния сервисов
                sh 'docker-compose -f $DOCKER_COMPOSE ps'
            }
        }

        stage('Test Frontend') {
            steps {
                // Запуск тестов для фронтенда ( администраторов)
                sh 'docker-compose -f $DOCKER_COMPOSE run --rm storage54.front.admin npm test'
                
                // Запуск тестов для фронтенда (публика)
                sh 'docker-compose -f $DOCKER_COMPOSE run --rm storage54.front.public npm test'
            }
        }

        stage('Test Backend (Laravel)') {
            steps {
                // Запуск тестов для бэкенда Laravel (публика)
                sh 'docker-compose -f $DOCKER_COMPOSE run --rm storage54.api.public php artisan test'
                
                // Запуск тестов для бэкенда Laravel (админ)
                sh 'docker-compose -f $DOCKER_COMPOSE run --rm storage54.api.admin php artisan test'
            }
        }

        stage('Shut down all services') {
            steps {
                // Остановка всех сервисов и удаление контейнеров после тестирования
                sh 'docker-compose -f $DOCKER_COMPOSE down'
            }
        }
    }
    
    post {
        always {
            // Выполняем очистку контейнеров и томов после выполнения тестов
            sh 'docker-compose -f $DOCKER_COMPOSE down --volumes'
        }
        success {
            echo 'All services have been successfully tested!'
        }
        failure {
            echo 'Some services failed the tests.'
        }
    }
}
