<div align="center">

# 🏛️ Mufti Gallery

### *A Curated Collection of Rare & Timeless Pieces*

An elegant antiques marketplace built with Laravel — browse, collect, and curate paintings, vases, handcrafts, and other rare finds.

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![React](https://img.shields.io/badge/React-19-61DAFB?style=flat&logo=react&logoColor=white)](https://react.dev)
[![Inertia](https://img.shields.io/badge/Inertia.js-3.0-9553E9?style=flat)](https://inertiajs.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

</div>

---

## ✨ Features

### 🛍️ For Customers
- **Browse the collection** — filterable catalog of paintings, antique pieces, vases, handcrafts, and old electronics
- **Multi-image galleries** — each piece can showcase up to 10 photos with a full-screen lightbox viewer (keyboard navigation included)
- **Shopping cart** — add, update quantities, and remove items
- **Order tracking** — place orders and follow their status (pending → info requested → confirmed/cancelled)
- **Account registration & secure login** — built on Laravel Fortify with two-factor auth support

### 🗂️ For Admins
- **Inventory management** — create, edit, and remove pieces with drag-and-drop multi-image uploads
- **Live gallery management** — add or remove product photos with instant AJAX feedback (no page reloads)
- **Order fulfillment** — review customer orders, request more info, confirm, or cancel
- **Unified admin dashboard** — sticky navbar with quick access to Products and Orders from anywhere

---

## 🧱 Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 13, PHP 8.3+ |
| **Auth** | Laravel Fortify (2FA, email verification) |
| **Frontend** | Blade templates + React 19 / Inertia.js (for auth & dashboard) |
| **Styling** | Custom CSS design system (vintage parchment & gold theme) + Tailwind CSS |
| **Database** | MySQL / SQLite |
| **Build Tooling** | Vite |

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & npm
- MySQL (or SQLite for quick local setup)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/ahm4dmufti/web2proj.git
cd web2proj

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env, then run migrations
php artisan migrate

# 6. (Optional) Seed sample products
php artisan db:seed

# 7. Build frontend assets
npm run dev    # for local development
# or
npm run build  # for production
```

### Run the app

```bash
php artisan serve
```

Visit `http://localhost:8000` 🎉

---

## 👥 User Roles

| Role | Access |
|---|---|
| **Customer** | Browse catalog, manage cart, place & track orders |
| **Admin** | Full product & order management via the admin dashboard (`/products`) |

---

## 📁 Project Structure Highlights

```
app/Http/Controllers/
├── ProductController.php       # Catalog, gallery, inventory CRUD
├── CartController.php          # Cart operations
├── OrderController.php         # Customer orders
└── Admin/OrderController.php   # Admin order management

resources/views/
├── catalog.blade.php           # Public storefront
├── products/                   # Admin product management + gallery
├── cart/, orders/              # Customer cart & order views
├── admin/orders/               # Admin order management
└── partials/
    ├── admin-nav.blade.php     # Shared admin navbar
    └── customer-nav.blade.php  # Shared customer navbar
```

---

<div align="center">

© 2026 Mufti Gallery for Antiques — All Rights Reserved

</div>
