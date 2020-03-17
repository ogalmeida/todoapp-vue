<template>
  <div class="d-flex mt-5 justify-content-center align-items-center">
    <div>
      <img class="img-fluid" src="../../../public/images/task.svg">
    </div>
    <div class="font-great">
      <div>
        <p class="text-white">Lorem, ipsum dolor sit amet consectetur adipisicing elit. In ipsa dolore rerum necessitatibus quibusdam ad amet inventore veniam aperiam, dignissimos exercitationem numquam sunt reprehenderit itaque fugit! Corporis, eum ipsum! Quo.</p>
      </div>
      <div class="mt-5">
        <router-link :to="{name: 'tasks'}" class="btn btn-outline-light">Go to Tasks<i class="fas ml-3 fa-hand-point-right"></i></router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.font-great{
  font-size: 18px;
}
</style>