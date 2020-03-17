<template>
  <div id="tasks">
    <div v-show="!loading">
      <div v-if="tasks.lenght > 0">
        <span v-for="task in tasks" :key="task.id" class="zoom list-group-item list-group-item-action text-left mt-3 shadow p-3 bg-dark rounded border border-success text-success">
          <div class="d-flex w-100 justify-content-between align-items-center">
            <h5 class="mb-1">{{task.title}}</h5>
            <small>Finished at: {{task.updated_at.substring(0, 10)}}</small>
          </div>
          <p class="mb-1">{{task.description}}</p>
          <div>
            <button @click="unfinishTask(task.id)" class="btn btn-outline-light btn-sm">Mark as unfinished<i class="fas ml-3 fa-undo"></i></button>
          </div>
        </span>
      </div>
      <div v-else>
        <div>
          <h4 class="text-white">You have no finished tasks <i class="fas ml-3 fa-grin-squint"></i></h4>
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <router-link role="button" :to="{name: 'tasks'}" class="btn mt-2 btn-light float-right">All tasks<i class="fas ml-2 fa-tasks"></i></router-link>
      </div>
    </div>
    <loading v-show="loading"></loading>
  </div>
</template>

<style scoped>
.zoom{
  transition: .4s;
}

.zoom:hover{
  transform: scale(1.01);
}
</style>

<script>
import Loading from './Loading'

export default {
  components:{
    Loading
  },
  data() {
    return {
      tasks: [],
      loading: false
    };
  },

  created() {
    this.loading = true,
    setTimeout(() => {
      this.load()
    }, 800);
  },

  methods: {
    load(){
      window.axios.get("api/finished").then(response => {
        this.tasks = response.data,
        this.toggleLoading()
      });
    },

    toggleLoading(){
      this.loading = !this.loading;
    },

    unCheck(id){
      this.loading = true,
      window.axios.get(`api/unfinish/${id}`).then(response => {
        this.load()
      });
    }, 

    unfinishTask(id){
      this.loading = true,
      window.axios
          .get(`api/task/unfinish/${id}`)
          .then((response) => {
              // console.log(response.data)
              this.load()
          });
    }
  }
};
</script>
