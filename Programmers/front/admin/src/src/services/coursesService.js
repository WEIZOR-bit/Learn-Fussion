import axiosService from '@/services/AxiosService.js';

const coursesService = {
    async getCourses() {
        return  axiosService.get('/api/admin/courses'); // Убедитесь, что этот URL правильный
    },
    getCourse(id) {
        return axiosService.get(`/courses/${id}`);
    },
    createCourse(userData) {
        return axiosService.post('/courses', courseData);
    },
    updateCourse(id, userData) {
        return axiosService.put(`/courses/${id}`, courseData);
    },
    deleteCourse(id) {
        return axiosService.delete(`/courses/${id}`);
    },
};

export default coursesService;