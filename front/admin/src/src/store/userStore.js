import { defineStore } from 'pinia';
import axiosService from '@/services/AxiosService.js';
import {reactive} from "vue";

export const useUserStore = defineStore('user', {
    state: () => ({
        users: reactive({
            current_page: 1,
            data: [],
            total: 0,
            per_page: 10,
            last_page: 1,
        }),
        isLoading: false,
        error: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
        hasUsers: (state) => state.users.data.length > 0, // Геттер для проверки наличия пользователей
    },
    actions: {
        async fetchUsers(page = 1) {
            this.isLoading = true; // Устанавливаем состояние загрузки
            this.error = null; // Сбрасываем ошибки перед запросом

            try {
                const response = await axiosService.get(`/users?page=${page}`);
                // Обновляем состояние, не переопределяя объект
                this.users.current_page = response.data.current_page;
                this.users.total = response.data.total;
                this.users.per_page = response.data.per_page;
                this.users.last_page = response.data.last_page;
                this.users.data = response.data.data; // Обновляем только массив пользователей
            } catch (error) {
                console.error('Ошибка при получении пользователей:', error);
                this.error = error; // Сохраняем ошибку в состоянии
                throw error; // Бросаем ошибку дальше
            } finally {
                this.isLoading = false; // Снимаем состояние загрузки
            }
        },
        async fetchUserById(id) {
            //
        },
        async addUser(payload) {
            this.isLoading = true; // Устанавливаем состояние загрузки
            this.error = null; // Сбрасываем ошибки перед запросом

            try {
                const response = await axiosService.post(`/users`, payload);
                // Обновляем массив пользователей, добавляя нового
                this.users.data.push(response.data); // Предполагается, что ответ содержит добавленного пользователя
                this.users.total += 1; // Увеличиваем общее количество пользователей
                return response.data; // Возвращаем добавленного пользователя
            } catch (error) {
                console.error('Ошибка при добавлении пользователя:', error);
                this.error = error; // Сохраняем ошибку в состоянии
                throw error; // Бросаем ошибку дальше
            } finally {
                this.isLoading = false; // Снимаем состояние загрузки
            }
        }
    },
});
