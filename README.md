# 🎁 Freecycle Listings Platform

A lightweight Laravel application where registered users can give away items for free.  
Other users can browse listings, vote, and comment — creating a simple, **community-driven exchange platform**.

---

## ✨ Features

### 🔐 Authentication
- Only registered users can access the main application.
- Guests are redirected to the login/registration screen.

---

## 📦 Item Listings
Each item includes:

- **Title, description, category, city**
- **Optional:** weight, dimensions
- **One or more photos**
- **Status:** `available` / `gifted`

Users can:

- Create new listings
- Edit their own listings
- Mark an item as *gifted*

---

## 🔍 Browsing & Filtering
- Paginated listings with thumbnails  
- Filter by **category**, **city**, or **status**  
- Text search (title or description)  
- Sorting options: **newest** or **most upvoted**

---

## 📝 Item Details
Each listing page shows:

- Full description
- All photos
- Owner information
- Comments
- Voting controls
- A **“Gifted” badge** when applicable

---

## 👍 Interactions
- Upvotes & downvotes (one per user per item)
- Commenting on items
- Dynamic UX with minimal full-page reloads

---

## 🧱 Conceptual Data Model

- **User**
- **Item**
- **Category**
- **Comment**
- **Vote**
- *(Optional)* Photo/Image entity

---

## 🚀 Quick Start

This project uses **Docker Compose + Laravel Sail** for local development.

### **Prerequisites**
- Docker installed & running  
- Any terminal shell (Bash, Zsh, etc.)

---

## ⚙️ Setup Steps

### **1. Start Docker Containers**

Build and start required services (PHP, MySQL, Mailpit, etc.):

```sh
docker compose up -d --build
````

---

### **2. Install Dependencies**

```sh
docker compose run --rm php composer install
```

Or, if Sail is installed locally:

```sh
./vendor/bin/sail composer install
```

---

### **3. Configure Environment**

```sh
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

---

### **4. Run Database Migrations + Seeders**

```sh
./vendor/bin/sail artisan migrate --seed
```

---

### **5. Access the Application**

Default local URLs:

* **Application:** [http://localhost:8059](http://localhost:8059)
* **Mailpit (Email Testing):** [http://localhost:8025](http://localhost:8025)

---

## 🧰 Useful Sail Commands

| Task           | Command                             |
| -------------- | ----------------------------------- |
| Run migrations | `./vendor/bin/sail artisan migrate` |
| Tinker console | `./vendor/bin/sail artisan tinker`  |
| Run tests      | `./vendor/bin/sail test`            |
| Compile assets | `./vendor/bin/sail npm run dev`     |

---

## 📄 License

This project is open-source and available under the **MIT License**.
