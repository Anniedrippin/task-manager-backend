# ✅ Mini Task Manager Application

A full-stack task management app built using **Laravel (API)** and **Vue.js (SPA frontend)**. The app allows users to register, log in, and manage tasks with CRUD operations. Deployed on **AWS EC2** with **Apache**.

---

## 🔧 Tech Stack

- **Backend**: Laravel 10, Sanctum, MySQL
- **Frontend**: Vue.js 3, Vue Router, Pinia, Tailwind CSS
- **Deployment**: AWS EC2 (Ubuntu), Apache, optional AWS S3 (not used)

---

## 🚀 Live Demo

- **Frontend & API**: [http://localhost:5173/tasks] & (http://56.228.18.112:8000)

---

## ✨ Features

- ✅ User Registration & Login (via Laravel Sanctum)
- ✅ Task CRUD: Create, Read, Update, Delete
- ✅ Mark tasks as completed
- ✅ Responsive design using Tailwind CSS
- ✅ Vue Router for page routing
- ✅ Pinia for state management
- ✅ Basic form validation & user feedback

---

## 📦 Project Structure


---

### Notes on Apache:

1. **Serving Frontend**: The `dist/` folder from the Vue.js build should be uploaded to `/var/www/html/` (or another folder configured in your Apache config).
   
2. **Apache Config for Reverse Proxy**: If you need to reverse proxy your Laravel API requests, you'll need to modify your Apache config (`/etc/apache2/sites-available/000-default.conf`) to include something like:

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/yourapp/public
    <Directory /var/www/yourapp/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

