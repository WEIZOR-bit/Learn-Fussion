import { defineStore } from 'pinia';
import axiosService from '@/services/AxiosService.js';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || '',
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        async login(email, password) {
            try {
                // Пример запроса на авторизацию
                const response = await axiosService.post('/login', { email, password });
                console.log(response);
                // Получаем токен из ответа
                this.token = response.data.token.access_token; // Извлечение токена
                this.user = response.data.admin; // Извлечение данных пользователя

                // Сохраняем токен в localStorage
                localStorage.setItem('token', this.token);

                // После успешного логина, axiosInstance автоматически добавит заголовок авторизации через интерцептор
            } catch (error) {
                console.error('Ошибка при входе:', error);
                throw error;
            }
        },
        logout() {
            this.user = null;
            this.token = '';

            // Удаляем токен из localStorage
            localStorage.removeItem('token');
        },
        async fetchUser() {
            try {
                if (this.token) {
                    // Запрос для получения данных о текущем пользователе
                    const response = await axiosService.get('/user');
                    this.user = response.data;
                }
            } catch (error) {
                console.error('Ошибка при получении данных пользователя:', error);
                this.logout(); // Если токен недействителен, выходим
            }
        },
    },
});
