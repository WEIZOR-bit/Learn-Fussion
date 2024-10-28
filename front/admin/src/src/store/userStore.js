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
        hasUsers: (state) => state.users.data.length > 0,
    },
    actions: {
        async fetchUsers(page = 1) {
            this.isLoading = true;
            this.error = null;

            try {
                const response = await axiosService.get(`/users?page=${page}`);
                // Обновляем состояние, не переопределяя объект
                this.users.current_page = response.data.current_page;
                this.users.total = response.data.total;
                this.users.per_page = response.data.per_page;
                this.users.last_page = response.data.last_page;
                this.users.data = response.data.data;
            } catch (error) {
                console.error('Ошибка при получении пользователей:', error);
                this.error = error;
                throw error;
            } finally {
                this.isLoading = false;
            }
        },
        async fetchUserById(id) {
            //
        },
        async addUser(payload) {
            this.isLoading = true;
            this.error = null;

            try {
                const response = await axiosService.post(`/users`, payload);
                this.users.data.push(response.data);
                this.users.total += 1;
                return response.data;
            } catch (error) {
                console.error('Ошибка при добавлении пользователя:', error);
                this.error = error;
                throw error;
            } finally {
                this.isLoading = false;
            }
        },

        async search(page = 1, query = null) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await axiosService.get(`/users/search?page=${page}&query=${query}`);
                console.log('response', response);
                this.users.current_page = response.data.current_page;
                this.users.total = response.data.total;
                this.users.per_page = response.data.per_page;
                this.users.last_page = response.data.last_page;
                this.users.data = response.data.data;
            }
            catch (error) {
                console.error('Ошибка при получении пользователей:', error);
            }
            finally {
                this.isLoading = false;
            }
        }
    },


});
