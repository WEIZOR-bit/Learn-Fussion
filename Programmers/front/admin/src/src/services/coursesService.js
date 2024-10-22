import axiosService from '@/services/AxiosService.js';

const coursesService = {
    async getCourses() {
        return  axiosService.get('/courses');
    },
    getCourse(id) {
       return axiosService.get(`/courses/${id}`);
    },
    createCourse(courseData) {
        return axiosService.post('/courses', courseData);
    },
    createLesson(lessonData, id) {

        console.log('course id', id.id);
        console.log('lesson data', lessonData.lessons);
        return axiosService.post(`/courses/${id.id}/lessons`, lessonData);
    },

    publishCourse(id) {
        return axiosService.post(`/courses/${id}/publish`)
    },

    updateCourse(id, courseData) {
        return axiosService.put(`/courses/${id}`, courseData);
    },
    deleteCourse(id) {
        return axiosService.delete(`/courses/${id}`);
    },
    async getCategories() {
        return axiosService.get('/categories');
    },

    async deleteCover(id) {
        return axiosService.delete(`courses/${id}/cover`);
    }
};

export default coursesService;