<template>
    <div class="form-container">
        <h3>{{ task && task.id ? 'Edit Task' : 'New Task' }}</h3>
        <form @submit.prevent="saveTask">
            <input v-model="title" type="text" placeholder="Title" required />
            <textarea v-model="description" placeholder="Description"></textarea>
            <input v-model="due_date" type="date" required />
            <button type="submit">{{ task && task.id ? 'Update' : 'Add' }} Task</button>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { useAuthStore } from '../stores/auth'

const props = defineProps({ task: Object })
const emit = defineEmits(['saved'])
const auth = useAuthStore()

const title = ref('')
const description = ref('')
const due_date = ref('')

watch(() => props.task, (newTask) => {
    if (newTask) {
        title.value = newTask.title
        description.value = newTask.description
        due_date.value = newTask.due_date
    } else {
        title.value = ''
        description.value = ''
        due_date.value = ''
    }
}, { immediate: true })

const saveTask = async () => {
    const payload = {
        title: title.value,
        description: description.value,
        due_date: due_date.value,
        status: props.task?.status || false, // status is boolean
    }

    if (props.task && props.task.id) {
        await axios.put(`/tasks/${props.task.id}`, payload, {
            headers: { Authorization: `Bearer ${auth.token}` }
        })
    } else {
        await axios.post('/tasks', payload, {
            headers: { Authorization: `Bearer ${auth.token}` }
        })
    }

    emit('saved')
}
</script>

<style scoped>
.form-container {
    margin: 2rem 0;
    padding: 1.5rem;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    color: #333;
}

.form-container h3 {
    margin-bottom: 1rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #5f1919;
}

form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

input[type="text"],
input[type="date"],
textarea {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 100%;
    box-sizing: border-box;
    font-family: inherit;
    background-color: #fdfdfd;
}

input:focus,
textarea:focus {
    outline: none;
    border-color: #5f1919;
    box-shadow: 0 0 0 2px rgba(95, 25, 25, 0.1);
}

textarea {
    min-height: 100px;
    resize: vertical;
}

button[type="submit"] {
    align-self: flex-start;
    background-color: #5f1919;
    color: white;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

button[type="submit"]:hover {
    background-color: #842020;
}
</style>
