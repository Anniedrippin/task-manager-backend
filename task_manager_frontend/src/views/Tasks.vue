<template>
    <div class="tasks-container">
        <!-- Header -->
        <header class="header">
            <h2>📝 Task Manager</h2>
            <button class="btn logout-btn" @click="logout">Logout</button>
        </header>

        <!-- Task Form Component -->
        <section class="task-form-section">
            <task-form :task="selectedTask" @saved="fetchTasks" />
        </section>

        <hr class="divider" />

        <!-- Task List -->
        <div v-if="tasks.length === 0" class="empty-message">
            No tasks found. Add a new one above! 🚀
        </div>

        <ul class="task-list" v-else>
            <li v-for="task in tasks" :key="task.id" class="task-item">
                <div class="task-details">
                    <h3 :class="{ done: task.status }">{{ task.title }}</h3>
                    <p class="task-desc">{{ task.description }}</p>
                    <div class="due-container">
                        <small class="due-date">📅 Due: {{ task.due_date }}</small>
                    </div>
                </div>

                <div class="task-actions">
                    <button class="btn edit-btn" @click="editTask(task)">✏️ Edit</button>
                    <button class="btn delete-btn" @click="deleteTask(task.id)">🗑️ Delete</button>
                    <button v-if="!task.status" class="btn complete-btn" @click="markComplete(task)">
                        ✅ Mark Complete
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuthStore } from '../stores/auth'
import TaskForm from '../components/TaskForm.vue'

const auth = useAuthStore()
const tasks = ref([])
const selectedTask = ref(null)

const fetchTasks = async () => {
    const res = await axios.get('/tasks', {
        headers: { Authorization: `Bearer ${auth.token}` },
    })
    tasks.value = res.data
    selectedTask.value = null
}

const editTask = (task) => {
    selectedTask.value = { ...task }
}

const deleteTask = async (id) => {
    await axios.delete(`/tasks/${id}`, {
        headers: { Authorization: `Bearer ${auth.token}` },
    })
    fetchTasks()
}

const markComplete = async (task) => {
    await axios.put(
        `/tasks/${task.id}`,
        {
            title: task.title,
            description: task.description,
            due_date: task.due_date,
            status: true,
        },
        {
            headers: { Authorization: `Bearer ${auth.token}` },
        }
    )
    fetchTasks()
}

const logout = async () => {
    await axios.post(
        '/logout',
        {},
        {
            headers: { Authorization: `Bearer ${auth.token}` },
        }
    )
    auth.logout()
    window.location.href = '/login'
}

onMounted(fetchTasks)
</script>

<style scoped>
.tasks-container {
    max-width: 800px;
    margin: 3rem auto;
    padding: 2.5rem;
    background-color: #5f1919;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #fff;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.task-form-section {
    margin-bottom: 2rem;
}

.divider {
    margin: 2rem 0 1rem;
    border: 0;
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
}

.empty-message {
    text-align: center;
    color: #ddd;
    font-style: italic;
    margin-top: 2rem;
}

.task-list {
    list-style: none;
    padding: 0;
    margin-top: 1rem;
}

.task-item {
    background-color: #fff;
    border: 1px solid #e3e3e3;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.5rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    color: #333;
}

.task-item:hover {
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
}

.task-details {
    flex: 1;
    min-width: 250px;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.task-details h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.4;
}

.task-desc {
    margin: 0;
    font-size: 1rem;
    color: #444;
    line-height: 1.6;
    word-break: break-word;

}

.due-container {
    margin-top: 0.5rem;
}

.due-date {
    font-size: 0.9rem;
    color: #666;
}

.task-actions {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    flex-wrap: wrap;
    min-width: 200px;
}

.btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s ease;
    white-space: nowrap;
}

.logout-btn {
    background-color: #f44336;
    color: white;
}

.edit-btn {
    background-color: #2196f3;
    color: white;
}

.delete-btn {
    background-color: #e91e63;
    color: white;
}

.complete-btn {
    background-color: #4caf50;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

.done {
    text-decoration: line-through;
    color: #999;
}
</style>
