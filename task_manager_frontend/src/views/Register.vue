<template>
    <div class="auth-container">
        <h2>Register</h2>
        <form @submit.prevent="handleRegister">
            <input v-model="name" type="text" placeholder="Name" required />
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required />
            <button type="submit">Register</button>
            <p v-if="success">Registration successful! You can now login.</p>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
        <router-link to="/login">Already have an account? Login</router-link>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const success = ref(false)
const error = ref(null)

const handleRegister = async () => {
    error.value = null
    try {
        await auth.register({
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value
        })
        success.value = true
        name.value = email.value = password.value = password_confirmation.value = ''
    } catch (err) {
        error.value = err.response?.data?.message || 'Registration failed.'
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
