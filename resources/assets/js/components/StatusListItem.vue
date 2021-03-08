<template>
  <div class="card mb-3 border-0 shadow-sm">
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
    </div>
    <div
      class="card-footer p-2 d-flex justify-content-between align-items-center"
    >
      <like-button
        :model="status"
        :url="`/statuses/${this.status.id}/likes`"
        dusk="like-btn"
      >
      </like-button>

      <div class="text-secondary mr-2">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count">{{ status.likes_count }}</span>
      </div>
    </div>
    <div class="card-footer">
      <div v-for="comment in comments" :key="comment.id" class="mb-3">
        <img
          width="34px"
          :src="comment.user_avatar"
          class="rounded shadow-sm float-left mr-2"
          :alt="comment.user_name"
        />
        <div class="card border-0 shadow-sm">
          <div class="card-body p-2 text-secondary">
            <a href="#">
              <strong> {{ comment.user_name }}</strong>
            </a>
            {{ comment.body }}
          </div>
        </div>
        <span dusk="comment-likes-count">{{ comment.likes_count }}</span>

        <like-button
          dusk="comment-like-btn"
          :url="`/comments/${comment.id}/likes`"
          :model="comment"
        >
        </like-button>       
       
      </div>
      <form @submit.prevent="addComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img
            width="34px"
            src="https://www.beahero.gg/wp-content/uploads/2019/07/Re-Zero-Rem.jpg"
            class="rounded shadow-sm mr-2"
            :alt="currentUser.name"
          />
          <div class="input-group">
            <textarea
              v-model="newComment"
              name="comment"
              class="form-control border-0 shadow-sm"
              rows="1"
              placeholder="Escribe un comentario..."
              required
            ></textarea>
            <div class="input-group-append">
              <button class="btn btn-primary" dusk="comment-btn">Enviar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import LikeButton from "./LikeButton.vue";
export default {
  props: {
    status: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      newComment: "",
      comments: this.status.comments,
    };
  },
  components: {
    LikeButton,
  },
  methods: {
    addComment() {
      axios
        .post(`/statuses/${this.status.id}/comments`, { body: this.newComment })
        .then((res) => {
          this.newComment = "";
          this.comments.push(res.data.data);
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
  
  },
};
</script>

<style>
</style>