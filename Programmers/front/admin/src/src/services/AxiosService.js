// services/axiosService.js
import axios from 'axios';
import { useAuthStore } from '@/store/auth';

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL || 'http://0.0.0.0/api/admin',
});

axiosInstance.interceptors.request.use(
    (config) => {
        const authStore = useAuthStore();
        const token = authStore.token;

        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axiosInstance.interceptors.response.use(
    (response) => {
        console.log(response.data);
        return response;
    },
    (error) => {
        if (error.response && error.response.status === 401) {
            const authStore = useAuthStore();
            authStore.logout();
            // window.location.href = 'admin/sign-in';
        }
        return Promise.reject(error);
    }
);

const axiosService = {
    get(url, params = {}) {
        return axiosInstance.get(url, { params });
    },
    post(url, data) {
        console.log(data);
        return axiosInstance.post(url, data);
    },
    put(url, data) {
        return axiosInstance.put(url, data);
    },
    delete(url) {
        return axiosInstance.delete(url);
    },
};

export default axiosService;
