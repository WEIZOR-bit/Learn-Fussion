import { defineStore } from 'pinia';
import axios from 'axios';
import coursesService from "@/services/coursesService.js";
import axiosService from "@/services/AxiosService.js";
import {reactive} from "vue";

export const useCoursesStore = defineStore('coursesStore', {
    state: () => ({
        courses: reactive({
            current_page: 1,
            data: [],
            total: 0,
            per_page: 10,
            last_page: 1,
        }),
        categories: reactive({
           category: []
        }),
        course: [],
        isLoading: false,
        error: null,
    }),
    actions: {
        async fetchCourses() {
            this.isLoading = true;
            this.error = null;
            console.log("перед траем");
            try {
                const response = await coursesService.getCourses();
                console.log(response.data);
                this.courses.current_page = response.data.current_page;
                this.courses.total = response.data.total;
                this.courses.per_page = response.data.per_page;
                this.courses.last_page = response.data.last_page;
                this.courses.data = response.data.data;
                console.log(this.courses);

            } catch (error) {
                console.log("в кетче");
                this.error = error.response?.data?.message || 'Error fetching courses';
            } finally {
                this.isLoading = false;
            }
        },

        async fetchCourseById(id) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await coursesService.getCourse(id);
                this.course = response.data;
                console.log('from course store', response.data);
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching course';
            } finally {
                this.isLoading = false;
            }
        },

        async publishCourse(id) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await coursesService.publishCourse(id);
                this.course = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error publishing course';
            } finally {
                this.isLoading = false;
            }
        },

        async addCourse(courseData) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await coursesService.createCourse(courseData);
            } catch (error) {
                this.error = error.response?.data?.message || 'Error adding course';
            } finally {
                this.isLoading = false;
            }
        },
        async addLesson(lessonData, id) {
            this.isLoading = true;
            this.error = null;
            try {
                console.log('Lesson data', lessonData);
                const response = await coursesService.createLesson(lessonData, id);

            } catch (error) {
                this.error = error.response?.data?.message || 'Error adding course';
            } finally {
                this.isLoading = false;
            }
        },

        async updateCourse(id, courseData) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await axiosService.post(`/courses/${id}?_method=PUT`, courseData);

                const index = this.courses.findIndex(course => course.id === id);
                if (index !== -1) {
                    this.courses[index] = { ...this.courses[index], ...courseData };
                }
                console.log(response.data)
                return response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error updating course';
            } finally {
                this.isLoading = false;
            }
        },

        async deleteCourse(id) {
            this.isLoading = true;
            this.error = null;
            try {
                await axios.delete(`/api/courses/${id}`);
                this.courses = this.courses.filter(course => course.id !== id);
            } catch (error) {
                this.error = error.response?.data?.message || 'Error deleting course';
            } finally {
                this.isLoading = false;
            }
        },

        async getCategories() {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await coursesService.getCategories();
                console.log(response.data);
                this.categories.category = response.data;

            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching courses';
            } finally {
                this.isLoading = false;
            }
        },

        async deleteCover(id) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await coursesService.deleteCover(id);
                console.log('from delete',response);
            }  catch (error) {
                this.error = error.response?.data?.message || 'Error fetching courses';
            } finally {
                this.isLoading = false;
            }
        },


        async search(page = 1, query = null) {
            this.error = null;
            try {
                const response = await axiosService.get(`/courses/search?page=${page}&query=${query}`);
                console.log('response', response);
                this.courses.current_page = response.data.current_page;
                this.courses.total = response.data.total;
                this.courses.per_page = response.data.per_page;
                this.courses.last_page = response.data.last_page;
                this.courses.data = response.data.data;
            }
            catch (error) {
                console.error('Ошибка при получении пользователей:', error);
            }
        }
    },
});
