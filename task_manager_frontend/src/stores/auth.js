import { defineStore } from "pinia";
import axios from "axios";

// Set Axios base URL (you may want to set this globally)
axios.defaults.baseURL = "http://localhost:8000/api"; // Adjust this if your API is hosted elsewhere

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),
    actions: {
        async login(credentials) {
            const res = await axios.post("/login", credentials); // No need to repeat the base URL here
            this.token = res.data.token;
            localStorage.setItem("token", this.token);
            await this.fetchUser();
        },
        async register(data) {
            const res = await axios.post("/register", data);
            // Optional auto-login: uncomment below if desired
            // this.token = res.data.token;
            // localStorage.setItem("token", this.token);
            // await this.fetchUser();
        },
        async fetchUser() {
            const res = await axios.get("/user", {
                headers: { Authorization: `Bearer ${this.token}` },
            });
            this.user = res.data;
        },
        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem("token");
        },
    },
});
