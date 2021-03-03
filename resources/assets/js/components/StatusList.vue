<template>
  <div>
    <div
      class="card mb-3 border-0 shadow-sm"
      v-for="status in statuses"
      :key="status.id"
    >
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center mb-3">
          <img
            class="rounded mr-3"
            width="40px"
            src="https://www.beahero.gg/wp-content/uploads/2019/07/Re-Zero-Rem.jpg"
            alt=""
          />
          <div>
            <h5 class="mb-1" v-text="status.user_name"></h5>
            <div class="small text-muted" v-text="status.ago"></div>
          </div>
        </div>
        <p class="card-text text-secondary" v-text="status.body"></p>
        <button
          v-if="status.is_liked"
          class="btn btn-primary"
          dusk="unlike-btn"
          @click="unlike(status)"
        >
          TE GUSTA
        </button>
        <button
          v-else
          class="btn btn-primary"
          dusk="like-btn"
          @click="like(status)"
        >
          ME GUSTA
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      statuses: [],
    };
  },
  mounted() {
    axios
      .get("/statuses")
      .then((res) => {
        this.statuses = res.data.data;
        // console.log(res);
      })
      .catch((err) => {
        console.log(err.response.data);
      });

    EventBus.$on("status-created", (status) => {
      this.statuses.unshift(status);
    });
  },
  methods: {
    like(status) {
      axios
        .post(`/statuses/${status.id}/likes`)
        .then((res) => {
          status.is_liked = true;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    unlike(status) {
      axios
        .delete(`/statuses/${status.id}/likes`)
        .then((res) => {
          status.is_liked = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style>
</style>