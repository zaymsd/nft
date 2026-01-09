---
description: Workflow untuk mengkonversi NFT-Verse ke website dinamis dengan MySQL dan auth
---

# Workflow: Convert NFT-Verse to Dynamic Website

## Prerequisites
- XAMPP/Laragon dengan PHP 7.4+ dan MySQL
- phpMyAdmin atau MySQL CLI
- Text editor (VS Code recommended)

## Step 1: Create Database
// turbo
```bash
cd c:\laragon\www\nft
mysql -u root -e "CREATE DATABASE nftverse_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## Step 2: Create config folder and database.php
Create file `config/database.php` with PDO connection to nftverse_db.

## Step 3: Create database schema
Create file `database/nftverse.sql` with all table definitions from ERD.

## Step 4: Import database schema
// turbo
```bash
mysql -u root nftverse_db < c:\laragon\www\nft\database\nftverse.sql
```

## Step 5: Create session handler
Create file `includes/session.php` with login helper functions.

## Step 6: Create auth pages
- Create `auth/login.php` 
- Create `auth/register.php`
- Create `auth/logout.php`

## Step 7: Update header.php
Add login/logout buttons based on session status.

## Step 8: Create admin panel
- Create `admin/index.php` (dashboard)
- Create `admin/nfts.php` (CRUD NFTs)
- Create `admin/team.php` (CRUD team members)
- Create `admin/roadmap.php` (CRUD roadmap)
- Create `admin/users.php` (user management)
- Create `admin/settings.php`

## Step 9: Update frontend pages
- Modify `index.php` to query from database
- Modify `pages/gallery.php` to query from database
- Modify `pages/team.php` to query from database
- Modify `pages/roadmap.php` to query from database
- Modify `pages/mint.php` to record transactions

## Step 10: Test all features
- Test register/login/logout
- Test admin CRUD operations
- Test frontend displays data correctly
- Test newsletter subscription

## Step 11: Add security measures
- Add CSRF tokens to forms
- Validate and sanitize all inputs
- Use prepared statements for all queries
