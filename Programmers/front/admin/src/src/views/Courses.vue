<template>
  <div>
    <LoaderComponent v-if="isLoading"/>
    <div v-else class="py-4 container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Courses</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                  <tr>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                    >
                      Name
                    </th>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                    >
                      Category
                    </th>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                    >
                      Author
                    </th>
                    <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                    >
                      Publication
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(course, index) in courses" :key="index">
                    <td class="tmy-auto">
                      <div class="d-flex px-2">
                        <div>
                          <!-- <img/> -->
                        </div>
                        <div class="my-auto">
                          <h6 class="mb-0 text-sm" @click="goToCourse(course.id)" style="cursor: pointer;">
                            {{ course.name }}
                          </h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">{{ course.category.name }}</p>
                    </td>
                    <td class="text-secondary font-weight-bolder opacity-7 ps-2">
                      <span class="text-xs font-weight-bold">{{ course.author }}</span>
                    </td>
                    <td class="text-secondary font-weight-bolder opacity-7 ps-2">
                      <span class="text-xs font-weight-bold">{{ course.published ? 'published' : 'unpublished' }}</span>
                    </td>
                    <td class="align-middle">
                      <div class="dropdown dropdown-wrapper">
                        <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                          <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end ">
                          <li>
                            <a class="dropdown-item" @click="goToCourse(course.id)">Open</a>
                          </li>
                          <li>
                            <a class="dropdown-item" @click="editCourse(course.id)">Edit</a>
                          </li>
                          <li>
                            <a class="dropdown-item text-danger" @click="deleteCourse(course.id)">Delete</a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <button @click="openAddCoursesComponent" class="btn btn-primary">Add Course</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


import AddUserComponent from "@/views/components/AddUserComponent.vue";
import SoftPagination from "@/components/VsudPagination.vue";
import SoftPaginationItem from "@/components/VsudPaginationItem.vue";
import {useCoursesStore} from "@/store/coursesStore.js";
import {computed, onMounted, ref} from "vue";
import router from "@/router/index.js";
import LoaderComponent from "@/views/components/LoaderComponent.vue";

export default {
  components: {
    LoaderComponent,
    SoftPagination,
    SoftPaginationItem,
  },
  setup() {
    const coursesStore = useCoursesStore();
    const isLoading = ref(false);
    const error = ref(null);
    const currentUser = ref(null);
    const courses = computed(() => coursesStore.courses.data);


    const fetchCourses = async () => {
      isLoading.value = true;
      error.value = null;
      try {
        await coursesStore.fetchCourses();
      } catch (err) {
        error.value = err;
      } finally {
        isLoading.value = false;
      }
    };

    const goToCourse = (id) => {
      router.push({name: 'Course Details', params: {id}});
    }

    const editCourse = (id) => {

    }

    const deleteCourse = (id) => {

    }


    const openAddCoursesComponent = () => {
      router.push({name: 'Add Course'});
    };


    onMounted(fetchCourses);

    return {
      courses,
      isLoading,
      error,
      currentUser,
      fetchCourses,
      goToCourse,
      editCourse,
      deleteCourse,
      openAddCoursesComponent,
    };
  },
};
</script>


<style scoped>
.dropdown-menu {
  position: absolute !important; /* Меню будет позиционироваться независимо от таблицы */
  left: -100px; /* Позиционируем меню за пределами таблицы */
  overflow: visible;
}

.dropdown-wrapper {
  position: relative; /* Относительное позиционирование для обертки */
}

.table-responsive {
  overflow-x: visible
}


</style>
