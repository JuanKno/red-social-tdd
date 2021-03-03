<template>
  <div>
    <form @submit.prevent="submit" v-if="isAuthenticated">
      <div class="card-body">
        <textarea
          v-model="body"
          name="body"
          class="form-control border-0 bg-light"
          :placeholder="`¿Qué estás pensando ${currentUser.name}?`"
        >
        </textarea>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" id="create-status">
          <i class="fa fa-paper-plane  mr-1"></i>
          Publicar
        </button>
      </div>
    </form>
    <div class="card-body" v-else>
      <a href="/login" class="btn btn-primary">Deebs de iniciar sesión</a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      body: "",
    };
  },

  methods: {
    submit() {
      axios
        .post("/statuses", { body: this.body })
        .then((result) => {
          EventBus.$emit("status-created", result.data.data);
          this.body = "";
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
  },
};
</script>

<style></style>
