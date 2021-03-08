<template>
  <div>
    <button @click="toggle()" :class="getButtonClass">
      <i :class="getIconClass"></i> {{ getText }}
    </button>
  </div>
</template>

<script>
export default {
  props: {
    model: {
      type: Object,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
  },
  methods: {
    toggle() {
      let method = this.model.is_liked ? "delete" : "post";

      axios[method](this.url)
        .then((res) => {
          this.model.is_liked = !this.model.is_liked;
          if (method == "post") {
            this.model.likes_count++;
          } else {
            this.model.likes_count--;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  computed: {
    getText() {
      return this.model.is_liked ? "TE GUSTA" : "ME GUSTA";
    },
    getButtonClass() {
      return [
        this.model.is_liked ? "font-weight-bold" : "",
        "btn",
        "btn-link",
        "btn-sm",
      ];
    },
    getIconClass() {
      return [
        this.model.is_liked ? "fa" : "far",
        "fa-thumbs-up",
        "text-primary",
        "mr-1",
      ];
    },
  },
};
</script>

<style>
</style>