<template>
  <div class="modal-background">
    <div>
      <img src="../../../public/images/loading.svg">
    </div>
    <!-- {{image}} -->
  </div>
</template>

<style scoped>
.modal-background{
  position: absolute;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgb(0, 0, 0, 0.6);
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
}

</style>

<script>
export default {
}
</script>