<script>
import router from "@/router/index.js";
import {useRoute} from "vue-router";
import {useUserStore} from "@/stores/userStore.js";

export default {
  name: 'EmailVerify',
      setup () {
    const store = useUserStore()
    const route = useRoute()
    console.log(route.query);
        if (route.query.id) {
          store.setEmailVerifyQuery(route.query);
          store.apiUserVerification().then(() => {
            // После успешной верификации редиректим на профиль
            router.push('/profile');
          });
        } else {
      console.log('error')
      router.push('/error404')
    }
  }
}
</script>

<template>
  <div>This is email verify</div>
</template>

<style scoped>

</style>