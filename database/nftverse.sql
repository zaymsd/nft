-- =============================================
-- NFT-Verse Database Schema
-- Version: 1.0
-- Created: 2026-01-09
-- =============================================

-- Drop tables if exist (for fresh install)
DROP TABLE IF EXISTS `mint_transactions`;
DROP TABLE IF EXISTS `nft_traits`;
DROP TABLE IF EXISTS `nfts`;
DROP TABLE IF EXISTS `roadmap_milestones`;
DROP TABLE IF EXISTS `roadmap_phases`;
DROP TABLE IF EXISTS `team_members`;
DROP TABLE IF EXISTS `newsletter_subscribers`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;

-- =============================================
-- Table: users
-- =============================================
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') DEFAULT 'user',
    `wallet_address` VARCHAR(100) NULL,
    `avatar_url` VARCHAR(255) NULL,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_users_email` (`email`),
    INDEX `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: nfts
-- =============================================
CREATE TABLE `nfts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `token_id` VARCHAR(10) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `rarity` ENUM('common', 'rare', 'epic', 'legendary') NOT NULL DEFAULT 'common',
    `price` DECIMAL(10, 4) NOT NULL DEFAULT 0.08,
    `rarity_score` DECIMAL(5, 1) NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `is_featured` BOOLEAN DEFAULT FALSE,
    `is_minted` BOOLEAN DEFAULT FALSE,
    `owner_id` INT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_nfts_rarity` (`rarity`),
    INDEX `idx_nfts_is_featured` (`is_featured`),
    INDEX `idx_nfts_is_minted` (`is_minted`),
    FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: nft_traits
-- =============================================
CREATE TABLE `nft_traits` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nft_id` INT NOT NULL,
    `trait_type` VARCHAR(50) NOT NULL,
    `trait_value` VARCHAR(100) NOT NULL,
    `rarity_percentage` INT NULL,
    FOREIGN KEY (`nft_id`) REFERENCES `nfts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: team_members
-- =============================================
CREATE TABLE `team_members` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `nickname` VARCHAR(50) NULL,
    `role` VARCHAR(100) NOT NULL,
    `bio` TEXT NULL,
    `avatar_url` VARCHAR(255) NULL,
    `twitter_url` VARCHAR(255) NULL,
    `linkedin_url` VARCHAR(255) NULL,
    `github_url` VARCHAR(255) NULL,
    `instagram_url` VARCHAR(255) NULL,
    `discord_url` VARCHAR(255) NULL,
    `display_order` INT DEFAULT 0,
    `is_active` BOOLEAN DEFAULT TRUE,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: roadmap_phases
-- =============================================
CREATE TABLE `roadmap_phases` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `phase_name` VARCHAR(20) NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `status` ENUM('completed', 'progress', 'upcoming') NOT NULL DEFAULT 'upcoming',
    `status_text` VARCHAR(50) NOT NULL,
    `display_order` INT DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: roadmap_milestones
-- =============================================
CREATE TABLE `roadmap_milestones` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `phase_id` INT NOT NULL,
    `milestone_text` VARCHAR(255) NOT NULL,
    `is_completed` BOOLEAN DEFAULT FALSE,
    `display_order` INT DEFAULT 0,
    FOREIGN KEY (`phase_id`) REFERENCES `roadmap_phases`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: mint_transactions
-- =============================================
CREATE TABLE `mint_transactions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `nft_id` INT NULL,
    `wallet_address` VARCHAR(100) NOT NULL,
    `eth_amount` DECIMAL(10, 4) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `transaction_hash` VARCHAR(100) NULL,
    `status` ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_transactions_user` (`user_id`),
    INDEX `idx_transactions_status` (`status`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`nft_id`) REFERENCES `nfts`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: newsletter_subscribers
-- =============================================
CREATE TABLE `newsletter_subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `is_subscribed` BOOLEAN DEFAULT TRUE,
    `subscribed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `unsubscribed_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: settings
-- =============================================
CREATE TABLE `settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(50) NOT NULL UNIQUE,
    `setting_value` TEXT NULL,
    `setting_type` VARCHAR(20) DEFAULT 'string',
    `description` VARCHAR(255) NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Insert Default Admin User
-- Password: admin123 (change in production!)
-- =============================================
INSERT INTO `users` (`username`, `email`, `password_hash`, `role`) VALUES
('admin', 'admin@nftverse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- =============================================
-- Insert Default Settings
-- =============================================
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('mint_price', '0.08', 'number', 'Harga mint per NFT dalam ETH'),
('total_supply', '10000', 'number', 'Total supply NFT'),
('minted_count', '7842', 'number', 'Jumlah NFT yang sudah di-mint'),
('max_per_transaction', '10', 'number', 'Maksimal NFT per transaksi'),
('countdown_date', '2026-03-01 00:00:00', 'datetime', 'Tanggal public mint'),
('discord_url', 'https://discord.gg/nftverse', 'string', 'URL Discord'),
('twitter_url', 'https://twitter.com/nftverse', 'string', 'URL Twitter'),
('instagram_url', 'https://instagram.com/nftverse', 'string', 'URL Instagram'),
('site_name', 'NFT-Verse', 'string', 'Nama website'),
('site_description', 'Koleksi NFT eksklusif dengan utility nyata', 'string', 'Deskripsi website');

-- =============================================
-- Insert Sample Team Members
-- =============================================
INSERT INTO `team_members` (`name`, `nickname`, `role`, `bio`, `avatar_url`, `twitter_url`, `linkedin_url`, `github_url`, `instagram_url`, `discord_url`, `display_order`) VALUES
('Zaelani Mursid', 'zaym', 'Founder & CEO', 'Memiliki rekam jejak lebih dari satu dekade di industri blockchain dan berhasil mengelola proyek NFT dengan penjualan mencapai $50 juta.', 'https://i.pravatar.cc/300?img=12', 'https://twitter.com', 'https://linkedin.com', NULL, NULL, NULL, 1),
('Sarah Park', 'CodeQueen', 'Lead Developer', 'Full-stack blockchain developer. Former Ethereum Foundation contributor with expertise in smart contracts.', 'https://i.pravatar.cc/300?img=5', 'https://twitter.com', NULL, 'https://github.com', NULL, NULL, 2),
('Marcus Rivera', 'PixelMaster', 'Art Director', 'Award-winning digital artist. Worked with major brands and created art for Fortune 500 companies.', 'https://i.pravatar.cc/300?img=33', 'https://twitter.com', NULL, NULL, 'https://instagram.com', NULL, 3),
('Emily Foster', 'Web3Guru', 'Community Manager', 'Built and managed communities of 100k+ members. Expert in engagement and growth strategies.', 'https://i.pravatar.cc/300?img=9', 'https://twitter.com', NULL, NULL, NULL, 'https://discord.gg', 4),
('David Lee', 'MarketingNinja', 'Marketing Lead', 'Growth hacker with proven track record. Generated $10M+ revenue across multiple Web3 projects.', 'https://i.pravatar.cc/300?img=15', 'https://twitter.com', 'https://linkedin.com', NULL, NULL, NULL, 5),
('Rachel Kim', 'SmartContract', 'Blockchain Architect', 'Security researcher and auditor. Audited 50+ smart contracts with zero security breaches.', 'https://i.pravatar.cc/300?img=16', 'https://twitter.com', NULL, 'https://github.com', NULL, NULL, 6);

-- =============================================
-- Insert Sample Roadmap Phases
-- =============================================
INSERT INTO `roadmap_phases` (`phase_name`, `title`, `status`, `status_text`, `display_order`) VALUES
('Q1 2024', 'Genesis - Peluncuran & Komunitas', 'completed', 'Selesai', 1),
('Q2 2024', 'Evolusi - Peluncuran Utilitas', 'progress', 'Dalam Proses', 2),
('Q3 2024', 'Ekspansi - Integrasi Metaverse', 'upcoming', 'Segera Hadir', 3),
('Q4 2024', 'Revolusi - DAO & Masa Depan', 'upcoming', 'Masa Depan', 4);

-- =============================================
-- Insert Sample Roadmap Milestones
-- =============================================
INSERT INTO `roadmap_milestones` (`phase_id`, `milestone_text`, `is_completed`, `display_order`) VALUES
-- Q1 2024
(1, '10.000 NFT Terjual Habis dalam 48 Jam', TRUE, 1),
(1, 'Komunitas Discord Mencapai 15.000 Anggota', TRUE, 2),
(1, 'Pengungkapan Lengkap Semua Trait Koleksi', TRUE, 3),
(1, 'Donasi $50.000 untuk Mitra Amal', TRUE, 4),
(1, 'Kemitraan dengan Marketplace NFT Utama', TRUE, 5),
-- Q2 2024
(2, 'Peluncuran Platform Staking (Live)', TRUE, 1),
(2, 'Pembukaan Toko Merchandise Eksklusif', FALSE, 2),
(2, 'Mekanisme Breeding Generasi Pertama', FALSE, 3),
(2, 'Acara Komunitas & AMA Pemegang NFT', FALSE, 4),
(2, 'Rilis Beta Aplikasi Mobile', FALSE, 5),
-- Q3 2024
(3, 'Airdrop Token $CRYPTO untuk Semua Pemegang', FALSE, 1),
(3, 'Peluncuran Beta Game Play-to-Earn', FALSE, 2),
(3, 'Penjualan Tanah Virtual di Dunia NFT-Verse', FALSE, 3),
(3, 'Kolaborasi dengan Selebriti & Brand', FALSE, 4),
(3, 'Koleksi NFT Generasi Kedua', FALSE, 5),
-- Q4 2024
(4, 'Implementasi Tata Kelola DAO Penuh', FALSE, 1),
(4, 'Grand Opening Metaverse NFT-Verse', FALSE, 2),
(4, 'Pengembangan Bridge Cross-Chain', FALSE, 3),
(4, 'Acara Fisik & Konferensi Pemegang', FALSE, 4),
(4, 'Pengumuman Kemitraan Strategis', FALSE, 5);

-- =============================================
-- Insert Sample NFTs
-- =============================================
INSERT INTO `nfts` (`token_id`, `name`, `rarity`, `price`, `rarity_score`, `image_path`, `is_featured`, `is_minted`) VALUES
('0001', 'Cyber Samurai', 'legendary', 2.50, 98.5, 'assets/images/nft-1.png', TRUE, TRUE),
('0002', 'Neon Guardian', 'epic', 1.80, 85.2, 'assets/images/nft-2.png', TRUE, TRUE),
('0003', 'Digital Phoenix', 'rare', 1.20, 72.3, 'assets/images/nft-3.png', TRUE, TRUE),
('0004', 'Quantum Warrior', 'epic', 1.90, 88.7, 'assets/images/nft-4.png', TRUE, TRUE),
('0005', 'Cosmic Knight', 'legendary', 3.00, 96.1, 'assets/images/nft-5.png', FALSE, TRUE),
('0006', 'Virtual Dragon', 'rare', 0.95, 65.4, 'assets/images/nft-6.png', FALSE, TRUE),
('0007', 'Neon Phantom', 'epic', 1.50, 78.9, 'assets/images/nft-7.png', FALSE, FALSE),
('0008', 'Cyber Wolf', 'common', 0.08, 45.2, 'assets/images/nft-8.png', FALSE, FALSE),
('0009', 'Digital Hawk', 'rare', 0.85, 62.1, 'assets/images/nft-9.png', FALSE, FALSE),
('0010', 'Quantum Fox', 'common', 0.08, 38.7, 'assets/images/nft-10.png', FALSE, FALSE),
('0011', 'Holographic Tiger', 'epic', 1.65, 81.3, 'assets/images/nft-11.png', FALSE, FALSE),
('0012', 'Cyber Eagle', 'rare', 0.92, 67.8, 'assets/images/nft-12.png', FALSE, FALSE),
('0013', 'Neon Serpent', 'legendary', 2.80, 94.5, 'assets/images/nft-13.png', FALSE, FALSE),
('0014', 'Digital Bear', 'common', 0.08, 42.1, 'assets/images/nft-14.png', FALSE, FALSE),
('0015', 'Quantum Lion', 'epic', 1.75, 83.6, 'assets/images/nft-15.png', FALSE, FALSE);

-- =============================================
-- Insert Sample NFT Traits
-- =============================================
INSERT INTO `nft_traits` (`nft_id`, `trait_type`, `trait_value`, `rarity_percentage`) VALUES
(1, 'Background', 'Cyber City', 5),
(1, 'Body', 'Armored', 10),
(1, 'Eyes', 'Laser Red', 3),
(1, 'Weapon', 'Katana', 8),
(2, 'Background', 'Neon Grid', 12),
(2, 'Body', 'Guardian Suit', 7),
(2, 'Eyes', 'Glowing Blue', 15),
(2, 'Accessory', 'Shield', 9),
(3, 'Background', 'Digital Sky', 20),
(3, 'Body', 'Phoenix Form', 5),
(3, 'Wings', 'Fire Wings', 4),
(3, 'Aura', 'Golden', 6),
(4, 'Background', 'Quantum Realm', 8),
(4, 'Body', 'Battle Armor', 12),
(4, 'Eyes', 'Quantum Vision', 6),
(4, 'Weapon', 'Energy Blade', 10);
