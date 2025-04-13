<template>
    <div class="auth-container">
        <h2>Login</h2>
        <form @submit.prevent="handleLogin">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
        <router-link to="/register">Don't have an account? Register</router-link>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const email = ref('')
const password = ref('')
const error = ref(null)

const handleLogin = async () => {
    error.value = null
    try {
        await auth.login({ email: email.value, password: password.value })
        router.push('/tasks')
    } catch (err) {
        error.value = err.response?.data?.message || 'Login failed. Check credentials.'
    }
}
</script>

<style scoped>
.auth-container {
    max-width: 300px;
    margin: auto;
    padding: 20px;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>
