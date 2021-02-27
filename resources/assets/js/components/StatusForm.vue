<template>
  <div>
    <form @submit.prevent="submit">
      <div class="card-body">
        <textarea
          class="form-control border-0 bg-light"
          placeholder="¿Qué estás pensando Juan?"
          name="body"
          id="body"
          v-model="body"
        ></textarea>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" id="create-status">Publicar</button>
      </div>
    </form>
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
