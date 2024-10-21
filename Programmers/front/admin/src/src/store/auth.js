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
                const response = await axiosService.post('/login', { email, password });
                console.log(response);

                this.token = response.data.token.access_token; // Извлечение токена
                this.user = response.data.admin; // Извлечение данных пользователя


                localStorage.setItem('token', this.token);
                //сохор юзера
                localStorage.setItem('user', JSON.stringify(this.user));
                //срок токена



            } catch (error) {
                console.error('Ошибка при входе:', error);
                throw error;
            }
        },
        logout() {
            this.user = null;
            this.token = '';

            // Удаляем токен из localStorage
            localStorage.removeItem('user');
            localStorage.removeItem('token');
        },
        loadUserFromStorage() {
            const user = localStorage.getItem('user');
            const token = localStorage.getItem('token');
            if (user && token) {
                this.$patch({
                    user: JSON.parse(user),
                    token: token,
                });


            }
        },
        async uploadAvatar(formData, id) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await axiosService.post(`admin/${id}/avatar`, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                this.user.avatar_url = response.data.avatar_url;
                localStorage.setItem('user', JSON.stringify(this.user));
                return response;

            } catch (error) {
                this.error = error.response?.data?.message || 'Error uploading avatar';
            } finally {
                this.isLoading = false;
            }
        },


    },
});
