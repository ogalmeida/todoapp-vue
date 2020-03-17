<template>
  <div id="main" class="text-center pt-5">
    <h1 class="display-4">Vue App</h1>

    <p>
      <!-- <router-link :to="{name: 'register'}" role="button" class="btn btn-outline-dark font-weight-bold">Register <i class="fas ml-2 fa-plus"></i></router-link> -->
    </p>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style scoped>
#main{
  background-image: url(../../../public/images/Trianglify-20s-1920px.svg);
  background-size: cover;
  min-height: 100vh;
  /* height: 100%; */
}
</style>