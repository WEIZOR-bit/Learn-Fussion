import axios from 'axios';


// Создаем экземпляр axios с базовыми настройками
const services = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || 'http://0.0.0.0:8000/api/public', // Базовый URL для всех запросов
    timeout: 5000, // Максимальное время ожидания ответа
    headers: {
        'Content-Type': 'application/json',
    },
});

// Интерцептор для обработки запросов перед отправкой
// services.interceptors.request.use(
//     (config) => {
//         // Здесь можно добавить токен авторизации, если он нужен
//         const token = localStorage.getItem('authToken');
//         if (token) {
//             config.headers.Authorization = `Bearer ${token}`;
//         }
//         return config;
//     },
//     (error) => {
//         return Promise.reject(error);
//     }
// );

// Интерцептор для обработки ответов
services.interceptors.response.use(
    (response) => {
        // Если запрос успешный, просто возвращаем ответ
        return response;
    },
    (error) => {
        // Обрабатываем ошибки
        if (error.response && error.response.status === 401) {
            // Например, если 401 (Unauthorized), можно перенаправить на страницу логина
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export default services;
