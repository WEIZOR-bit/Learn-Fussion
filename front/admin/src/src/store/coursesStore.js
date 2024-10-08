import { defineStore } from 'pinia';
import axios from 'axios';
import coursesService from "@/services/coursesService.js";
import axiosService from "@/services/AxiosService.js";
import {reactive} from "vue";

export const useCoursesStore = defineStore('coursesStore', {
    state: () => ({
        courses: reactive([]),
        course: null,
        isLoading: false,
        error: null,
    }),
    actions: {
        async fetchCourses() {
            this.isLoading = true;
            this.error = null;
            console.log("перед траем");
            try {
                const response = await axiosService.get("/courses");
                console.log(response.data);
                this.courses = response.data.original;
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
                const response = await axios.get(`/api/courses/${id}`);
                this.course = response.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Error fetching course';
            } finally {
                this.isLoading = false;
            }
        },

        async addCourse(courseData) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await axios.post('/api/courses', courseData);
                this.courses.push(response.data);
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
                await axios.put(`/api/courses/${id}`, courseData);
                const index = this.courses.findIndex(course => course.id === id);
                if (index !== -1) {
                    this.courses[index] = { ...this.courses[index], ...courseData };
                }
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
    },
});
