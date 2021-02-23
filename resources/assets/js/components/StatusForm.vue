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
                <button class="btn btn-primary" id="create-status">
                    Publicar
                </button>
            </div>
        </form>
        <div
            v-for="status in statuses"
            :key="status.id"
            v-text="status.body"
        ></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            body: "",
            statuses: [],
        };
    },
    methods: {
        submit() {
            axios
                .post("/statuses", { body: this.body })
                .then((result) => {
                    this.statuses.push(result.data);
                    this.body = ''
                })
                .catch((err) => {
                    console.log(err.response.data);
                });
        },
    },
};
</script>

<style></style>
