<div align="center">

# 👟 Online Shoes Shopping Website

### A full-stack e-commerce platform for browsing, carting, and ordering footwear — with a complete admin panel.

[![PHP](https://img.shields.io/badge/PHP_8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-00758F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://jquery.com/)

</div>

---

## 📌 Overview

The **Online Shoes Shopping Website** is a PHP + MySQL e-commerce application with a rich product catalog, a multi-payment checkout flow, and a full-featured admin panel. Customers can browse 10 product categories, add items to a session-based cart, and place orders via Cash on Delivery, UPI, or Credit/Debit Card. Admins manage products, product groups, and orders from an SB Admin 2 themed dashboard.

---

## ✨ Features

### 🛍️ Customer
- Register and log in with password hashing (bcrypt)
- Browse 10 shoe categories: Men/Women Sneakers, Walking Shoes, Sandals, Cricket & Football Shoes, Children Clogs, School Shoes, and more
- View brand-specific pages (Nike, Puma)
- Add products to a session-based shopping cart
- Place orders with 3 payment methods: Cash on Delivery, UPI, Credit/Debit Card
- View order history (My Orders page) with live status tracking
- Generate bill/invoice for placed orders
- User profile management

### 🛠️ Admin
- Secure admin login (separate from user accounts)
- Dashboard with order overview
- Manage product groups (categories) — add/activate/deactivate
- Manage individual products — add with image upload, update, delete
- View all orders with status: Pending → Processing → Shipped → Out for Delivery → Delivered / Cancelled
- Change admin password

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, Bootstrap, jQuery, SB Admin 2 |
| Backend | PHP 8.2 |
| Database | MySQL (MariaDB 10.4) |
| Server | Apache (XAMPP / WAMP) |
| Product Images | Stored as BLOB in MySQL |

---

## 📁 Folder Structure

```
shoeswebsite/
├── shoes_admin/
│   ├── index.php                  # Admin login
│   ├── dashboard.php              # Admin dashboard
│   ├── manage-groups.php          # Product group/category management
│   ├── group_availability.php     # Toggle group status
│   ├── manage-products.php        # All products list
│   ├── add-product.php            # Add new product (with image)
│   ├── subject.php
│   ├── change-password.php
│   ├── session.php
│   ├── leftbar.php
│   ├── footer.php
│   ├── logout.php
│   └── dist/                      # SB Admin 2 CSS/JS assets
├── home.php                       # Customer homepage
├── sign_in.php                    # Login page
├── register.php                   # Registration page
├── cart.php                       # Shopping cart
├── place_order.php                # Checkout & order placement
├── clientsideorder.php            # Order confirmation
├── myorder.php                    # Order history
├── bill.php                       # Order invoice
├── upi.php                        # UPI payment page
├── creditcard.php                 # Card payment page
├── user_profile.php               # User profile
├── about.php                      # About page
├── contact_us.php                 # Contact page
├── sale.php                       # Sale/offers page
├── nike.php                       # Nike brand page
├── puma_shoes.php                 # Puma brand page
├── logout.php
│
├── [Category Pages]
│   ├── men_sneaker.php
│   ├── men_walking_shoes.php
│   ├── men_formal_shoes.php
│   ├── men_sandal.php
│   ├── men_boot_shoes.php
│   ├── men_slider.php
│   ├── men_clogs.php
│   ├── women_sneaker.php
│   ├── women_running_shoes.php
│   ├── women_sandal.php
│   ├── women_sleeper.php / women_slider.php / women_clog.php
│   ├── children_clog.php
│   ├── children_walking_shoes.php
│   ├── children_sandal.php
│   ├── Boy_school_shoes.php
│   ├── Girl_school_shoes.php
│   ├── cricket_shoes.php
│   └── football_shoes.php
│
└── database/
    └── webshoes.sql               # Full database dump
```

---

## 🚀 Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/)
- PHP 8.0+
- MySQL / MariaDB

### 1. Clone the Repository

```bash
git clone https://github.com/Mayank-Kaneriya1442/Online-Shoes-Shopping-Website.git
```

### 2. Move to Server Root

Copy the `shoeswebsite/` folder to:
- **XAMPP**: `C:/xampp/htdocs/shoeswebsite/`
- **WAMP**: `C:/wamp64/www/shoeswebsite/`

### 3. Import the Database

1. Start Apache and MySQL from XAMPP/WAMP
2. Open **phpMyAdmin** at `http://localhost/phpmyadmin`
3. Create a new database named `webshoes`
4. Import the file: `database/webshoes.sql`

### 4. Configure Database Connection

The DB connection is inline in each PHP file. Search for and update if needed:

```php
$conn = mysqli_connect("localhost", "root", "", "webshoes");
```

### 5. Run the Application

```
http://localhost/shoeswebsite/home.php          (Customer)
http://localhost/shoeswebsite/shoes_admin/      (Admin)
```

---

## 🔑 Default Credentials

> ⚠️ Change these credentials after first login.

| Role | Login ID | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |

Customer accounts are self-registered via `register.php`.

---

## 📦 Product Categories (10 Groups)

| # | Category |
|---|---------|
| 1 | Women Sneakers |
| 2 | Men Sneakers |
| 3 | Men Walking Shoes |
| 4 | Women Sandals |
| 5 | Children Clog |
| 6 | Children Walking Shoes |
| 7 | Cricket Shoes |
| 8 | Football Shoes |
| 9 | Boys School Shoes |
| 10 | Girls School Shoes |

---

## 🗃️ Database Schema

| Table | Description |
|-------|-------------|
| `product` | Product catalog — group, name, image (BLOB), price |
| `tbl_group` | Product categories with active/inactive status |
| `orders` | Orders — customer details, address, payment mode, status, total |
| `order_items` | Line items per order — product name, quantity, price |
| `register` | Customer accounts with bcrypt-hashed passwords |
| `tbl_login` | Admin credentials |

**Order Status Flow:** `Pending` → `Processing` → `Shipped` → `Out for Delivery` → `Delivered` / `Cancelled`

**Payment Methods:** Cash on Delivery · UPI · Credit/Debit Card

---

## 👨‍💻 Author

**Mayank Kaneriya**
- 🌐 [LinkedIn](https://www.linkedin.com/in/mayank-kaneriya-011729363/)
- 📧 mayankkaneriya15@gmail.com
- 💻 [GitHub](https://github.com/Mayank-Kaneriya1442)

---

<div align="center">

⭐ If you found this project helpful, please give it a star!

</div>
