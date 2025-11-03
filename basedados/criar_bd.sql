-- === CREATE DATABASE ===

CREATE DATABASE felixubershop_db;
USE felixubershop_db;

-- === CREATE TABLES ===

CREATE TABLE passwords (
	pw_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pw_hashed_password VARCHAR(255),
    
    pw_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    pw_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
	u_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    u_username VARCHAR(100) NOT NULL,
    u_email VARCHAR(100) NOT NULL,
    u_address VARCHAR(175),
    pw_id INT NOT NULL,
    
    u_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    u_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users_types (
	ut_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ut_type VARCHAR(13) NOT NULL,
    
    ut_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ut_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE wallets (
	w_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    w_money DECIMAL(15,2) NOT NULL,
    
    w_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    w_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE accounts (
	a_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    u_id INT NOT NULL,
    ut_id INT NOT NULL,
    w_id INT NOT NULL,
    
    a_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    a_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categories (
	c_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    c_name VARCHAR(100) NOT NULL,
    
    c_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    c_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
	p_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    p_name VARCHAR(175) NOT NULL,
    p_price DECIMAL(15,2) NOT NULL,
    p_stock INT DEFAULT 0 NOT NULL,
    p_discount INT DEFAULT 0 NOT NULL,
    c_id INT NOT NULL,
    
    p_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    p_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CHECK (p_discount BETWEEN 0 AND 100)
);

CREATE TABLE orders (
	o_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    o_name VARCHAR(125) NOT NULL,
    o_arrival_time TIMESTAMP NOT NULL,
    o_total_price DECIMAL(15,2) NOT NULL,
    a_id INT NOT NULL,
    
    o_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    o_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products_orders (
	po_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    p_id INT NOT NULL,
    o_id INT NOT NULL,
    
    po_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    po_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- === ALTER TABLE FOREIGN KEYS ===

-- 1. USERS FOREIGN KEYS
ALTER TABLE users
ADD CONSTRAINT fk_users_passwords
FOREIGN KEY (pw_id) REFERENCES passwords(pw_id);

-- 2. ACCOUNTS FOREIGN KEYS
ALTER TABLE accounts
ADD CONSTRAINT fk_accounts_users
FOREIGN KEY (u_id) REFERENCES users(u_id);

ALTER TABLE accounts
ADD CONSTRAINT fk_accounts_users_types
FOREIGN KEY (ut_id) REFERENCES users_types(ut_id);

ALTER TABLE accounts
ADD CONSTRAINT fk_accounts_wallets
FOREIGN KEY (w_id) REFERENCES wallets(w_id);

-- 3. PRODUCTS FOREIGN KEYS
ALTER TABLE products
ADD CONSTRAINT fk_products_categories
FOREIGN KEY (c_id) REFERENCES categories(c_id);

-- 4. ORDERS FOREIGN KEYS
ALTER TABLE orders
ADD CONSTRAINT fk_orders_accounts
FOREIGN KEY (a_id) REFERENCES accounts(a_id);

-- 5. PRODUCTS_ORDERS FOREIGN KEYS
ALTER TABLE products_orders
ADD CONSTRAINT fk_products_orders_products
FOREIGN KEY (p_id) REFERENCES products(p_id);

ALTER TABLE products_orders
ADD CONSTRAINT fk_products_orders_orders
FOREIGN KEY (o_id) REFERENCES orders(o_id);

-- === INSERTS ===

-- 1. CREATE USERS TYPES

INSERT INTO users_types(ut_type)
VALUES("client");

INSERT INTO users_types(ut_type)
VALUES("employee");

INSERT INTO users_types(ut_type)
VALUES("admin");

-- 2. CREATE FelixUberShop USER
INSERT INTO passwords(pw_hashed_password)
VALUES('$argon2id$v=19$m=65536,t=4,p=1$dFhubW5BSGVjbTdML3RhLw$8tkj6ztZK00ehOXuWShXj9SekJe6RiBOZ13p4iBoGpk');
-- VALUES('Felix_US_ADMIN_2025_!?');

INSERT INTO users(u_username, u_email, pw_id)
VALUES('FelixUberShop', 'felixubershop@gmail.com', 1);

INSERT INTO wallets(w_money)
VALUES(0.00);

INSERT INTO accounts(u_id, ut_id, w_id)
VALUES(1, 1, 1);

-- 3. CREATE CATEGORIES
INSERT INTO categories(c_name)
VALUES('fruits');

INSERT INTO categories(c_name)
VALUES('vegetables');

INSERT INTO categories(c_name)
VALUES('meats');

INSERT INTO categories(c_name)
VALUES('cereals');

INSERT INTO categories(c_name)
VALUES('wealth');

-- 4. CREATE PRODUCTS

-- FRUITS
INSERT INTO products(p_name, p_price, c_id)
VALUES('apple', 3.09, 1);

INSERT INTO products(p_name, p_price, c_id)
VALUES('banana', 1.83, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id)
VALUES('kiwi', 3.00, 25, 1);

-- VEGETABLES
INSERT INTO products(p_name, p_price, c_id)
VALUES('carrot', 1.00, 2);

INSERT INTO products(p_name, p_price, c_id)
VALUES('broccoli', 3.00, 2);

INSERT INTO products(p_name, p_price, p_discount, c_id)
VALUES('spinach', 3.50, 25, 2);

-- MEATS
INSERT INTO products(p_name, p_price, c_id)
VALUES('chicken', 6.00, 3);

INSERT INTO products(p_name, p_price, c_id)
VALUES('beef', 12.00, 3);

INSERT INTO products(p_name, p_price, p_discount, c_id)
VALUES('pork', 3.50, 50, 3);

-- CEREALS
INSERT INTO products(p_name, p_price, c_id)
VALUES('cornflakes', 3.50, 4);

INSERT INTO products(p_name, p_price, c_id)
VALUES('oats', 2.50, 4);

INSERT INTO products(p_name, p_price, p_discount, c_id)
VALUES('rice krispies', 2.00, 50, 4);

-- WEALTH
INSERT INTO products(p_name, p_price, c_id)
VALUES('shampoo', 5.00, 5);

INSERT INTO products(p_name, p_price, c_id)
VALUES('conditioner', 5.00, 5);

INSERT INTO products(p_name, p_price, c_id)
VALUES('body lotion', 7.00, 5);