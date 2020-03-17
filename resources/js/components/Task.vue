<template>
  <div id="tasks">
    <div v-show="!loading">
      <div v-if="!emptyTasks">
        <span v-for="task in tasks" :key="task.id" class="zoom list-group-item list-group-item-action text-left mt-3 shadow p-3 bg-dark text-white rounded border" :class="{'border-danger': (task.priority === 'high'), 'border-warning': (task.priority === 'medium'), 'border-primary': (task.priority === 'low')}">
          <div style="cursor: pointer;" @click="updateTask(task.id)">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <h5 class="mb-1">{{task.title}}</h5>
              <small>Last update: {{task.updated_at.substring(0, 10)}}</small>
              <small>Priority: {{task.priority}}</small>
            </div>
            <p class="mb-1">{{task.description}}</p>
          </div>
          <div class="d-flex justify-content-between">
            <div>
              <button @click="finishTask(task.id)" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
            </div>
            <div>
              <button type="button" @click="updatePriorityExternal(task.id, 1)" class="btn btn-sm mx-2 mt-2" :class="{'btn-primary': (task.priority === 'low'), 'btn-outline-primary': (task.priority !== 'low')}"><i class="fas fa-circle"></i></button>
              <button type="button" @click="updatePriorityExternal(task.id, 2)" class="btn btn-sm mx-2 mt-2" :class="{'btn-warning': (task.priority === 'medium'), 'btn-outline-warning': (task.priority !== 'medium')}"><i class="fas fa-circle"></i></button>
              <button type="button" @click="updatePriorityExternal(task.id, 3)" class="btn btn-sm mx-2 mt-2" :class="{'btn-danger': (task.priority === 'high'), 'btn-outline-danger': (task.priority !== 'high')}"><i class="fas fa-circle"></i></button>
            </div>
            <div>
              <button type="button" @click="deleteTask(task.id)" class="btn btn-sm mx-2 mt-2 btn-outline-danger ml-auto"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </span>
      </div>
      <div v-else>
        <h4 class="text-white">You {{tasks.lenght}} have no tasks yet <i class="fas ml-3 fa-grin-squint"></i></h4>
      </div>
      <div class="d-flex justify-content-between">
        <router-link role="button" :to="{name: 'finished'}" class="btn mt-2 btn-success float-right">Finished tasks<i class="fas ml-2 fa-check"></i></router-link>
        <a role="button" @click="showModal" class="btn mt-2 btn-light float-right">Add task<i class="fas ml-2 fa-plus"></i></a>
      </div>
    </div>

    <sweet-modal modal-theme="dark" overlay-theme="dark" ref="modalAddTask">
      <h4>New task</h4>
      <form class="text-left" @submit.prevent="addTask">
        <div class="d-flex">
          <div class="w-75">  
            <div class="form-group">
              <label for="title">Task title</label>
              <input type="text" class="form-control" v-model="task.title">
            </div>
            <div class="form-group">
              <label for="description">Task description</label>
              <textarea type="text" class="form-control" v-model="task.description" rows="5"></textarea>
            </div>
          </div>
          <div class="d-flex w-25 justify-content-center">
            <div class="d-flex flex-column">
              <span>Priority</span>
              <button type="button" @click="setPriority(1)" class="btn btn-sm mt-2" :class="{'btn-primary': priority.low, 'btn-outline-primary': !priority.low}">Low<i class="fas ml-3 fa-circle"></i></button>
              <button type="button" @click="setPriority(2)" class="btn btn-sm mt-2" :class="{'btn-warning': priority.medium, 'btn-outline-warning': !priority.medium}">Medium<i class="fas ml-3 fa-circle"></i></button>
              <button type="button" @click="setPriority(3)" class="btn btn-sm mt-2" :class="{'btn-danger': priority.high, 'btn-outline-danger': !priority.high}">High<i class="fas ml-3 fa-circle"></i></button>
              <button type="submit" class="btn mt-auto mb-3 btn-outline-primary">Save<i class="fas ml-3 fa-check"></i></button>
            </div>
          </div>
        </div>
      </form>
    </sweet-modal>

    <sweet-modal modal-theme="dark" overlay-theme="dark" ref="modalEditTask">
      <h4>Edit task</h4>
      <form class="text-left" @submit.prevent="sendUpdate(taskEdit.id)">
        <div>
          <div class="form-group">
            <label for="title">Task title</label>
            <input type="text" class="form-control" v-model="taskEdit.title">
          </div>
          <div class="form-group">
            <label for="description">Task description</label>
            <textarea type="text" class="form-control" v-model="taskEdit.description" rows="5"></textarea>
          </div>
        </div>
        <button type="submit" class="btn float-right mb-3 btn-outline-primary">Update<i class="fas ml-3 fa-check"></i></button>
      </form>
    </sweet-modal>

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
import { SweetModal } from 'sweet-modal-vue'

export default {
  components:{
    SweetModal,
    Loading
  },
  data() {
    return {
      emptyTasks: true,
      tasks: [],
      task: {
        priority: 1,
      },
      loading: true,
      priority: {
        low: true,
        medium: false,
        high: false,
      }, 
      taskEdit: { },
    };
  },

  created() {
    setTimeout(() => {
      this.load()
    }, 800);
    
  },

  methods: {
    load(){
      window.axios.get("api/tasks").then(response => {
        this.tasks = response.data,
        this.emptyTasks = this.tasks.length > 0 ? false : true
        this.toggleLoading()
      });
    },

    deleteTask(id){
      this.loading = true,
      window.axios
            .delete(`api/task/delete/${id}`)
            .then(response => {
              this.load()
            });
    },

    showModal(){
      this.$refs.modalAddTask.open()
    },

    addTask() {
      this.$refs.modalAddTask.close(),
      this.loading = true
      window.axios
          .post('api/task/add', this.task)
          .then(response => (
            this.load(),
            this.resetValue()
          ))
          .catch(error => console.log(error))
    },

    setPriority(priority){
      this.task.priority = priority;
      switch(priority){
        case 1:
          this.priority.low = true;
          this.priority.medium = false;
          this.priority.high = false;
          break;
        case 2:
          this.priority.low = false;
          this.priority.medium = true;
          this.priority.high = false;
          break;
        case 3:
          this.priority.low = false;
          this.priority.medium = false;
          this.priority.high = true;
          break;
      }
    },

    toggleLoading(){
      this.loading = !this.loading;
    },

    resetValue(){
      this.task = {
        title: "",
        description: "",
        priority: ""
      }
    },

    updateTask(id){
      this.taskEdit = this.tasks[this.tasks.map(item => item.id).indexOf(id)],
      this.$refs.modalEditTask.open()
    },

    sendUpdate(id){
      window.axios
          .post(`api/task/update/${id}`, this.taskEdit)
          .then((response) => {
              // console.log(response.data)
          });
    },

    updatePriorityExternal(id, priority){
      this.loading = true,
      this.taskEdit = {},
      this.taskEdit = {
        priority: priority
      }
      window.axios
          .post(`api/task/update/${id}`, this.taskEdit)
          .then((response) => {
              this.load()
          });
    },

    finishTask(id){
      this.loading = true,
      window.axios
          .get(`api/task/finish/${id}`)
          .then((response) => {
              // console.log(response.data)
              this.load()
          });
    }
  }
};
</script>
