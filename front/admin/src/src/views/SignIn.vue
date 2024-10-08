<template>
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="mt-8 card card-plain">
                <div class="pb-0 card-header text-start">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" class="text-start" @submit.prevent="login">
                    <label>Email</label>
                    <vsud-input v-model="email" type="email" placeholder="Email" name="email" id="email" />
                    <label>Password</label>
                    <vsud-input v-model="password" type="password" placeholder="Password" name="password" id="password" />
                    <div class="text-center">
                      <vsud-button
                          type="submit"
                          class="my-4 mb-2"
                          variant="gradient"
                          color="info"
                          full-width
                      >
                        Login
                      </vsud-button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8">
                <div
                    class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                    :style="{
                    backgroundImage: `url(${bgImg})`,
                  }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import VsudInput from "@/components/VsudInput.vue";
import VsudSwitch from "@/components/VsudSwitch.vue";
import VsudButton from "@/components/VsudButton.vue";
import bgImg from "@/assets/img/curved-images/curved9.jpg";
import { useAuthStore } from "@/store/auth"; // Импортируем хранилище Pinia для аутентификации
import {ref} from "vue"; // Для реактивных данных
import {useRouter} from "vue-router"; // Для перенаправления после логина

const body = document.getElementsByTagName("body")[0];

export default {
  name: "SigninPage",
  components: {
    Navbar,
    AppFooter,
    VsudInput,
    VsudSwitch,
    VsudButton,
  },
  setup() {
    const email = ref(''); // Данные для полей формы
    const password = ref('');
    const authStore = useAuthStore(); // Инициализируем хранилище Pinia
    const router = useRouter(); // Для перенаправления

    const login = async () => {
      console.log("Попытка логина с email:", email.value, "и паролем:", password.value);
      try {
        // Вызов функции логина из хранилища
        await authStore.login(email.value, password.value);
        // Перенаправляем на защищенную страницу
        console.log("Логин успешен, перенаправляем на dashboard");
        console.log("Токен пользователя:", authStore.token);
        console.log("Пользователь:", authStore.user);
        await router.push('/');
      } catch (error) {
        console.error("Ошибка при авторизации:", error);
      }
    };

    return {
      email,
      password,
      login,
      bgImg,
    };
  },
  beforeMount() {
    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
  },
};
</script>
