let user = document.head.querySelector('meta[name="user"]');

module.exports = {
    computed: {
        currentUser() {
            return JSON.parse(user.content);
        },

        isAuthenticated() {
            return !!user.content;
        },
        isUserGuest() {
            return !this.isAuthenticated;
        }
    },
    methods: {
        redirectIfGuest() {
            if (this.isUserGuest) return (window.location.href = "/login");
        }
    }
};