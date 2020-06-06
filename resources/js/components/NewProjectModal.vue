<template>
  <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
    <h1 class="font-normal mb-16 text-center text-2xl">Let's start something new</h1>

    <form @submit.prevent="submit">
    <div class="flex">
      <div class="flex-1 mr-4">
        <div class="mb-4">
          <label for="title" class="text-sm block mb-2">Title</label>
          <input
            type="text"
            id="title"
            class="border py-1 px-2 text-xs block w-full rounded"
            :class="errors.title ? 'border-red-300' : 'border-gray-300'"
            v-model="form.title"
          />
          <span class="text-xs italic text-error" v-if="errors.title" v-text="errors.title[0]"></span>
        </div>
        <div class="mb-4">
          <label for="description" class="text-sm block mb-2">description</label>
          <textarea
            type="text"
            id="description"
            class="border py-1 px-2 text-xs block w-full rounded"
            rows="7"
            v-model="form.description"
            :class="errors.description ? 'border-red-300' : 'border-gray-300'"
          ></textarea>
          <span class="text-xs italic text-error" v-if="errors.description" v-text="errors.description[0]"></span>
        </div>
      </div>

      <div class="flex-1 ml-4">
        <div class="mb-4">
          <label class="text-sm block mb-2">Need Some Tasks?</label>
          <input
            type="text"
            placeholder="Task 1"
            class="border border-gray-400 py-1 mb-4 px-2 text-xs block w-full rounded"
            v-for="task in form.tasks"
            v-bind:key="task"
            v-model="task.value"
          />
        </div>

        <button class="inline-flex items-center text-xs" @click="addTask">
          <span>Add New Task Field</span>
        </button>
      </div>
    </div>

    <footer class="flex justify-end">
      <button
        class="text-gray-600 no-underline hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded"
        @click="$modal.hide('new-project')"
      >Cancel</button>
      <button
        class="text-gray-600 no-underline bg-blue-400 hover:bg-blue-500 hover:no-underline py-2 px-4 text-white font-bold py-2 px-4 rounded"
      >Create Project</button>
    </footer>
  </modal>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: {
        title: "",
        description: "",
        tasks: [{ value: "" }]
      },
      errors:{

      }
    };
  },
  methods: {
    addTask() {
      this.form.tasks.push({ value: "" });
    },
    async submit() {
        try{
            
            location = (await axios.post("/projects", this.form)).data.message;
        }
      catch(error ){
          this.errors = error.response.data.errors;
      }
    }
  }
};
</script>