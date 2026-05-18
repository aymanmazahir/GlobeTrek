-- globetrek.sql - GlobeTrek Adventures Database Schema
-- Requirements: users, customers, staff, packages, bookings, payments, inquiries

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Drop existing tables to ensure clean import
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS inquiries;
DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS users;

-- 1. users
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('customer', 'staff', 'admin') NOT NULL DEFAULT 'customer',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. customers
CREATE TABLE `customers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `full_name` VARCHAR(128) NOT NULL,
  `phone` VARCHAR(32) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. staff
CREATE TABLE `staff` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `full_name` VARCHAR(128) NOT NULL,
  `department` VARCHAR(64) DEFAULT 'Operations',
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. packages
CREATE TABLE `packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `destination` VARCHAR(128) NOT NULL,
  `summary` TEXT,
  `price` DECIMAL(10,2) DEFAULT 0.00,
  `duration_days` INT DEFAULT 1,
  `image_url` VARCHAR(255) DEFAULT 'default_package.jpg',
  `status` ENUM('active', 'expired') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. bookings
CREATE TABLE `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `package_id` INT NOT NULL,
  `travel_date` DATE NOT NULL,
  `guests_count` INT DEFAULT 1,
  `status` ENUM('pending', 'approved', 'cancelled') NOT NULL DEFAULT 'pending',
  `total_price` DECIMAL(10,2) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. payments
CREATE TABLE `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(64) NOT NULL,
  `status` ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
  `transaction_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. inquiries
CREATE TABLE `inquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read', 'replied') DEFAULT 'unread',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- INSERT DEFAULT DATA --

-- Insert Admin (Password is: admin123)
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`) VALUES 
(1, 'admin@globetrek.com', '$2y$10$1iBuYMPUJEHBNDZRitYTvOZvWoHzLZnAeL5rj1360EJSeko/Nes.2', 'admin');

-- Insert Sample Staff (Password is: staff123)
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`) VALUES 
(2, 'staff@globetrek.com', '$2y$10$1iBuYMPUJEHBNDZRitYTvOZvWoHzLZnAeL5rj1360EJSeko/Nes.2', 'staff');
INSERT INTO `staff` (`user_id`, `full_name`, `department`) VALUES 
(2, 'John Doe', 'Booking Management');

-- Insert Sample Packages
INSERT INTO `packages` (`title`, `destination`, `summary`, `price`, `duration_days`, `image_url`) VALUES 
('Maldives Paradise Escape', 'Maldives', 'Enjoy crystal clear waters and luxurious overwater bungalows.', 1499.00, 5, 'maldives.jpg'),
('Swiss Alps Adventure', 'Switzerland', 'Skiing and hiking in the breathtaking Swiss Alps.', 2100.00, 7, 'swiss.jpg'),
('Kyoto Cultural Tour', 'Japan', 'Experience the rich history and beautiful temples of Kyoto.', 1250.00, 6, 'kyoto.jpg');

COMMIT;