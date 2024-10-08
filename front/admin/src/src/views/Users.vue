
<template>
  <div class="card mb-4">
    <div class="card-header pb-0">
      <h6>Users</h6>
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
              Email
            </th>
            <th
              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
            >
              Email verify
            </th>
            <th
              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
            >
              Mastery level
            </th>
            <th
              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
            >
              Hearts
            </th>
            <th
              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
            >
              Mastery tag
            </th>
            <th
              class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
            >
              Last active
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="isLoading">
            <td colspan="7" class="text-center">Loading...</td>
          </tr>
          <tr v-if="!isLoading && users.data.length === 0">
            <td colspan="7" class="text-center">No users found</td>
          </tr>
          <tr v-for="(user, index) in users.data" :key="index">
            <td class="tmy-auto">
              <div class="d-flex px-2">
                <div>
                  <!-- <img/> -->
                </div>
                <div class="my-auto">
                  <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                </div>
              </div>
            </td>
            <td>
              <p class="text-sm font-weight-bold mb-0">{{ user.email }}</p>
            </td>
            <td>
              <span class="text-xs font-weight-bold">{{ user.email_verified ? 'Verify' : 'Not verify' }}</span>
            </td>
            <td class="align-middle">
              <span class="text-xs font-weight-bold">{{ user.mastery_level }}</span>
            </td>
            <td class="text-secondary font-weight-bolder opacity-7 ps-2">
              <span class="text-xs font-weight-bold">{{ user.hearts }}</span>
            </td>
            <td class="text-secondary font-weight-bolder opacity-7 ps-2">
              <span class="text-xs font-weight-bold">{{ user.mastery_tag }}</span>
            </td>
            <td class="text-secondary font-weight-bolder opacity-7 ps-2">
              <span class="text-xs font-weight-bold">{{ user.last_active_at }}</span>
            </td>
            <td class="align-middle">
              <button class="btn btn-link text-secondary mb-0">
                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
              </button>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
          <soft-pagination color="success" size="sm">
            <soft-pagination-item @click="fetchUsers(users.current_page - 1)" :disabled="users.current_page === 1" prev />
            <soft-pagination-item
                v-for="page in users.last_page"
                :key="page"
                @click="fetchUsers(page)"
                :label="page"
                :active="users.current_page === page"
            />
            <soft-pagination-item @click="fetchUsers(users.current_page + 1)"  :disabled="users.current_page === users.last_page || users.total === 0"  next />
          </soft-pagination>
        </div>


      </div>
    </div>
  </div>
  <button type="button" class="btn btn-primary" @click="openAddUserComponent">Add User</button>


</template>

<script>
import {ref, onMounted, computed} from 'vue';
import { useUserStore } from '@/store/userStore';
import SoftPagination from "@/components/VsudPagination.vue";
import SoftPaginationItem from "@/components/VsudPaginationItem.vue";
import AddUserComponent from "@/views/components/AddUserComponent.vue";
import router from "@/router/index.js";

export default {
  components: {
    AddUserComponent,
    SoftPagination,
    SoftPaginationItem,
  },
  setup() {
    const userStore = useUserStore();
    const isLoading = ref(false);
    const error = ref(null);
    const currentUser = ref(null);




    const fetchUsers = async (page = 1) => {
      isLoading.value = true;
      error.value = null;
      try {
        await userStore.fetchUsers(page);
      } catch (err) {
        error.value = err;
      } finally {
        isLoading.value = false;
      }
    };


    const openAddUserComponent = () => {
      router.push({ name: 'Add User' });
    };

    onMounted(fetchUsers);

    return {
      users: userStore.users,
      isLoading,
      error,
      currentUser,
      fetchUsers,
      openAddUserComponent,
    };
  },
};
</script>

<style scoped>
.card {
  border-radius: 0.5rem;
  box-shadow: 0 0 2rem 0 rgba(136, 152, 170, 0.15);
}

.btn-primary {
  background-color: #cb0c9f;
  border-color: #cb0c9f;
}

.btn-primary:hover {
  background-color: #9c0a75;
  border-color: #9c0a75;
}



</style>
