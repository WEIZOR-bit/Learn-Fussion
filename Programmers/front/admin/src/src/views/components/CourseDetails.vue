<template>
  <div>
    <LoaderComponent v-if="isLoading"/>
    <div v-else>
      <div>
        <card-component :title="course.name"></card-component>
      </div>
      <div>
        <card-component :title="course.description"></card-component>
      </div>
      <div class="card-container">
        <card-component :title="'Review count: ' + reviewCount"></card-component>
        <card-component :title="'Average rating: ' + course.average_rating"></card-component>
        <card-component :title="'Published: ' + course.published"></card-component>
        <card-component :title="'Created by: ' + course.creator?.name"></card-component>
      </div>
      <div>
        <card-component v-for="(lesson, index) in course.lessons" :key="index"
                        :title="'Lesson ' + (index + 1) + ': ' + lesson.name"></card-component>
      </div>
      <div class="nav-wrapper position-relative end-0">
        <button type="button" @click="goToAddLesson" class="btn btn-success">Add lesson</button>
        <button type="button" @click="goToCourses" class="btn btn-outline-dark">Back</button>
        <button v-if="!published" type="button" @click="publish" class="btn btn-danger">Publish</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {useCoursesStore} from '@/store/coursesStore';
import {onMounted, computed} from 'vue';
import {useRouter} from 'vue-router';
import {useRoute} from 'vue-router';
import CardComponent from "@/examples/Cards/Card.vue";
import LoaderComponent from "@/views/components/LoaderComponent.vue";


const courseStore = useCoursesStore();
const router = useRouter();
const route = useRoute();
const isLoading = computed(() => courseStore.isLoading);


const course = computed(() => courseStore.course);
const reviewCount = computed(() => course.value.review_count ?? 0);
const published = computed(() => course.value.published);


onMounted(() => {
  const courseId = route.params.id;
  courseStore.fetchCourseById(courseId);
});


const goToAddLesson = () => {
  let id;
  id = route.params.id;
  router.push({name: 'Add Lesson', params: {id}});
};

const goToCourses = async () => {
  await router.push({name: 'Courses'});
}

const publish = async () => {
  const courseId = route.params.id;
  await courseStore.publishCourse(courseId)
  await courseStore.fetchCourseById(courseId);
}
</script>

<style scoped>
.card-container {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  gap: 20px;
}
</style>
