-- === DROP DATABASE ===
-- DROP DATABASE felixubershop_db;

-- === DELETE DATABASE DATA ===

-- 1. Drop Foreign Keys
ALTER TABLE users
DROP FOREIGN KEY fk_users_passwords;

ALTER TABLE accounts
DROP FOREIGN KEY fk_accounts_users;

ALTER TABLE accounts
DROP FOREIGN KEY fk_accounts_users_types;

ALTER TABLE accounts
DROP FOREIGN KEY fk_accounts_users_status;

ALTER TABLE accounts
DROP FOREIGN KEY fk_accounts_wallets;

ALTER TABLE products
DROP FOREIGN KEY fk_products_categories;

ALTER TABLE products
DROP FOREIGN KEY fk_products_products_status;

ALTER TABLE orders
DROP FOREIGN KEY fk_orders_accounts;

ALTER TABLE orders
DROP FOREIGN KEY fk_orders_orders_status;

ALTER TABLE products_orders
DROP FOREIGN KEY fk_products_orders_products;

ALTER TABLE products_orders
DROP FOREIGN KEY fk_products_orders_orders;

-- 2. Drop Tables
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS passwords;
DROP TABLE IF EXISTS users_types;
DROP TABLE IF EXISTS users_status;
DROP TABLE IF EXISTS wallets;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS products_status;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS orders_status;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products_orders;

-- 3. Drop Views
DROP VIEW IF EXISTS get_all_users_info;
DROP VIEW IF EXISTS get_all_users;
DROP VIEW IF EXISTS get_all_products;

-- 4. Drop Functions
DROP FUNCTION IF EXISTS check_user_exists;
DROP FUNCTION IF EXISTS get_user_id;

-- 5. Drop Procedures
DROP PROCEDURE IF EXISTS get_user;
DROP PROCEDURE IF EXISTS create_user;
DROP PROCEDURE IF EXISTS sign_in;
DROP PROCEDURE IF EXISTS get_category_products;
DROP PROCEDURE IF EXISTS get_product;
DROP PROCEDURE IF EXISTS get_stock;