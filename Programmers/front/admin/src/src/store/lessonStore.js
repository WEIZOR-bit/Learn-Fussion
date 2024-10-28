// store/lessonStore.js

import { defineStore } from 'pinia';
import axios from 'axios';
import axiosService from "@/services/AxiosService.js";
import coursesService from "@/services/coursesService.js";

export const useLessonStore = defineStore('lesson', {
    state: () => ({
        lessons: [],
        lesson: null,
        isLoading: false,
    }),

    getters: {
        // Здесь можно добавить геттеры для получения данных
    },

    actions: {
        async fetchLessons(lessonId) {
            this.isLoading = true;
            try {
                const response = await axiosService.get(`lessons/${lessonId}?include=course`);
                this.lesson = response.data;
                console.log('response ', this.lessons);

            } catch (error) {
                console.error('Ошибка при загрузке уроков:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async fetchLessonById(lessonId) {
            this.isLoading = true;
            try {
                const response = await axios.get(`/api/lessons/${lessonId}`);
                this.lesson = response.data;
            } catch (error) {
                console.error('Ошибка при загрузке урока:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async addLesson(courseId, lessonData) {
            this.isLoading = true;
            try {
                await axios.post(`/api/courses/${courseId}/lessons`, lessonData);
                // Можно обновить список уроков после добавления
                await this.fetchLessons(courseId);
            } catch (error) {
                console.error('Ошибка при добавлении урока:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async updateLesson(id, lessonData) {
            this.isLoading = true;
            try {
               const response = await coursesService.updateLesson(id, lessonData);
               console.log(response);
                // // Можно обновить детали урока после обновления
                // await this.fetchLessonById(id);
            } catch (error) {
                console.error('Ошибка при обновлении урока:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async deleteLesson(lessonId) {
            this.isLoading = true;
            try {
                await axios.delete(`/api/lessons/${lessonId}`);
                // Можно обновить список уроков после удаления
                this.lessons = this.lessons.filter(lesson => lesson.id !== lessonId);
            } catch (error) {
                console.error('Ошибка при удалении урока:', error);
            } finally {
                this.isLoading = false;
            }
        },
    },
});
