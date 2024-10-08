import axiosService from '@/services/AxiosService.js';

const userService = {
    getUsers() {
        return axiosService.get('/users');
    },
    getUser(id) {
        return axiosService.get(`/users/${id}`);
    },
    createUser(userData) {
        return axiosService.post('/users', userData);
    },
    updateUser(id, userData) {
        return axiosService.put(`/users/${id}`, userData);
    },
    deleteUser(id) {
        return axiosService.delete(`/users/${id}`);
    },
};

export default userService;