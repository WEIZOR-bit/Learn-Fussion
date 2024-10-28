<template>
  <div>
    <LoaderComponent v-if="isLoading"/>
    <div v-else class="py-4 container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6>Courses</h6>

<!--            search-->
            <div class="input-group">
            <span class="input-group-text text-body">
              <i class="fas fa-search" aria-hidden="true"></i>
            </span>
              <input
                  type="text"
                  v-model="searchQuery"
                  @input="debouncedSearch"
                  class="form-control"
                  :placeholder="
                'Type here...'
              "
              />
            </div>

<!--            category-->
            <div class="form-group mb-0">
              <label for="categoryFilter" class="text-xs font-weight-bold">Category:</label>
              <select v-model="selectedCategory" class="form-control form-control-sm" id="categoryFilter">
                <option value="">All Categories</option>
                <option v-for="category in categories.category" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light-green text-white pb-0 border-bottom">
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                  <table class="table align-items-center justify-content-center mb-0">
                    <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Author</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Publication</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(course, index) in filteredCourses" :key="index" class="table-row">
                      <td class="align-middle">
                        <div class="d-flex px-2">
                          <div class="my-auto">
                            <h6 class="mb-0 text-sm text-primary-light" @click="goToCourse(course.id)" style="cursor: pointer;">
                              {{ course?.name }}
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
                        <span :class="course.published ? 'text-success-status' : 'text-danger-status'">
                          {{ course?.published ? 'Published' : 'Unpublished' }}
                        </span>
                      </td>
                      <td class="align-middle">
                        <div class="dropdown dropdown-wrapper">
                          <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end">
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
          </div>
          <button @click="openAddCoursesComponent" class="btn btn-outline-success">Add Course</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useCoursesStore } from "@/store/coursesStore.js";
import {computed, onMounted, ref, watch} from "vue";
import router from "@/router/index.js";
import LoaderComponent from "@/views/components/LoaderComponent.vue";
import {debounce} from "lodash";

export default {
  components: {
    LoaderComponent,
  },
  setup() {
    const coursesStore = useCoursesStore();
    const isLoading = ref(false);
    const error = ref(null);
    const selectedCategory = ref("");
    const courses = computed(() => coursesStore.courses.data);
    const categories = computed(() => coursesStore.categories); // Assuming categories are fetched from the store
    const searchQuery = ref('');

    const fetchCourses = async () => {
      isLoading.value = true;
      error.value = null;
      try {
        await coursesStore.fetchCourses();
        await coursesStore.getCategories(); // Fetch categories from the store
      } catch (err) {
        error.value = err;
      } finally {
        isLoading.value = false;
      }
    };
    const debouncedSearch = debounce(() => {
      searchCourse(searchQuery.value);
    }, 500);

    watch(searchQuery, (newValue) => {
      debouncedSearch(); // Сброс к первой странице при изменении запроса
    });

    const searchCourse = async (page = 1) => {
      if (searchQuery.value === '') {
        await fetchCourses(page);
      } else {
        try {
          await coursesStore.search(page, searchQuery.value);
        } catch (err) {
          console.error(err);
        }
      }
    };


    const goToCourse = (id) => {
      router.push({ name: 'Course Details', params: { id } });
    };

    const openAddCoursesComponent = () => {
      router.push({ name: 'Add Course' });
    };

    const filteredCourses = computed(() => {
      if (!selectedCategory.value) return courses.value;
      return courses.value.filter(course =>
          course.category && course.category.id === selectedCategory.value
      );

    });

    onMounted(fetchCourses);

    return {
      courses,
      categories,
      isLoading,
      error,
      goToCourse,
      openAddCoursesComponent,
      selectedCategory,
      filteredCourses,
      searchQuery,
    };
  },
};
</script>

<style scoped>
.card {
  border-radius: 10px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-header {
  background-color: #d4edda;
  border-bottom: 2px solid #c3e6cb;
}

.table-row:hover {
  background-color: rgba(40, 167, 69, 0.1);
}

.text-primary-light {
  color: #28a745;
}

.text-success-status {
  color: #28a745;
  font-weight: 400;
  font-size: 0.85rem;
}

.text-danger-status {
  color: #dc3545;
  font-weight: 400;
  font-size: 0.85rem;
}

.dropdown-menu {
  position: absolute;
  left: -100px;
}

.table-responsive {
  overflow-x: visible;
}

.btn-outline-success {
  border: 2px solid #28a745;
  color: #28a745;
}

.btn-outline-success:hover {
  background-color: #28a745;
  color: #fff;
}

.btn-link {
  padding: 0;
}

.btn-link:hover {
  text-decoration: none;
  color: #28a745;
}

.btn {
  border-radius: 20px;
  font-weight: bold;
  padding: 10px 20px;
}

.dropdown-wrapper {
  position: relative;
}

.form-group {
  display: flex;
  align-items: center;
  gap: 5px;
}

.form-control {
  border-radius: 10px;
  padding: 3px 8px;
  font-size: 0.9rem;
}

.form-control-sm {
  width: auto;
}

.d-flex {
  align-items: center;
}
</style>
