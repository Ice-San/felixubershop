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
    u_email VARCHAR(100) NOT NULL UNIQUE,
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

CREATE TABLE users_status (
	us_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    us_status VARCHAR(8) NOT NULL,
    
    us_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    us_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    us_id INT NOT NULL,
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

CREATE TABLE products_status (
	ps_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ps_status VARCHAR(8),
    
    ps_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ps_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
	p_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    p_name VARCHAR(175) NOT NULL UNIQUE,
    p_price DECIMAL(15,2) NOT NULL,
    p_stock INT DEFAULT 0 NOT NULL,
    p_discount INT DEFAULT 0 NOT NULL,
    
    c_id INT NOT NULL,
    ps_id INT NOT NULL,
    
    p_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    p_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CHECK (p_discount BETWEEN 0 AND 100)
);

CREATE TABLE orders_status (
	os_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    os_status VARCHAR(8) NOT NULL,
    
    os_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    os_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE orders (
	o_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    o_name VARCHAR(125) NOT NULL,
    o_arrival_time TIMESTAMP NOT NULL,
    o_total_price DECIMAL(15,2) NOT NULL,
    
    a_id INT NOT NULL,
    os_id INT NOT NULL,
    
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
ADD CONSTRAINT fk_accounts_users_status
FOREIGN KEY (us_id) REFERENCES users_status(us_id);

ALTER TABLE accounts
ADD CONSTRAINT fk_accounts_wallets
FOREIGN KEY (w_id) REFERENCES wallets(w_id);

-- 3. PRODUCTS FOREIGN KEYS
ALTER TABLE products
ADD CONSTRAINT fk_products_categories
FOREIGN KEY (c_id) REFERENCES categories(c_id);

ALTER TABLE products
ADD CONSTRAINT fk_products_products_status
FOREIGN KEY (ps_id) REFERENCES products_status(ps_id);

-- 4. ORDERS FOREIGN KEYS
ALTER TABLE orders
ADD CONSTRAINT fk_orders_accounts
FOREIGN KEY (a_id) REFERENCES accounts(a_id);

ALTER TABLE orders
ADD CONSTRAINT fk_orders_orders_status
FOREIGN KEY (os_id) REFERENCES orders_status(os_id);

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

-- 2. CREATE CATEGORIES
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

-- 3. Create Products Status
INSERT INTO products_status(ps_status)
VALUES('active');

INSERT INTO products_status(ps_status)
VALUES('inactive');

-- 4. CREATE PRODUCTS

-- FRUITS
INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('apple', 3.09, 1, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('banana', 1.83, 1, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id, ps_id)
VALUES('kiwi', 3.00, 25, 1, 1);

-- VEGETABLES
INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('carrot', 1.00, 2, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('broccoli', 3.00, 2, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id, ps_id)
VALUES('spinach', 3.50, 25, 2, 1);

-- MEATS
INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('chicken', 6.00, 3, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('beef', 12.00, 3, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id, ps_id)
VALUES('pork', 3.50, 50, 3, 1);

-- CEREALS
INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('cornflakes', 3.50, 4, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('oats', 2.50, 4, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id, ps_id)
VALUES('rice krispies', 2.00, 50, 4, 1);

-- WEALTH
INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('shampoo', 5.00, 5, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('conditioner', 5.00, 5, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('body lotion', 7.00, 5, 1);

-- 5. Create Users Status
INSERT INTO users_status(us_status)
VALUES('active');

INSERT INTO users_status(us_status)
VALUES('inactive');

-- 6. Create Orders Status
INSERT INTO orders_status(os_status)
VALUES('active');

INSERT INTO orders_status(os_status)
VALUES('inactive');

-- 8. CREATE FelixUberShop USER
INSERT INTO passwords(pw_hashed_password)
VALUES('$argon2id$v=19$m=65536,t=4,p=1$dFhubW5BSGVjbTdML3RhLw$8tkj6ztZK00ehOXuWShXj9SekJe6RiBOZ13p4iBoGpk');
-- VALUES('Felix_US_ADMIN_2025_!?');

INSERT INTO users(u_username, u_email, pw_id)
VALUES('FelixUberShop', 'felixubershop@gmail.com', 1);

INSERT INTO wallets(w_money)
VALUES(0.00);

INSERT INTO accounts(u_id, ut_id, us_id, w_id)
VALUES(1, 1, 2, 1);

-- 9. Create Client User
INSERT INTO passwords(pw_hashed_password)
VALUES('$argon2id$v=19$m=65536,t=4,p=1$N2JCSlkuekRBcmtyTnBqUQ$58/o4diw9Zinfrkqy2zgfT2G/99lOiBV4WJ5OsjlQKM');
-- VALUES('cliente');

INSERT INTO users(u_username, u_email, pw_id)
VALUES('cliente', 'cliente@gmail.com', 2);

INSERT INTO wallets(w_money)
VALUES(0.00);

INSERT INTO accounts(u_id, ut_id, us_id, w_id)
VALUES(2, 1, 1, 2);

-- 10. Create Employee User
INSERT INTO passwords(pw_hashed_password)
VALUES('$argon2id$v=19$m=65536,t=4,p=1$aXJCZDh0Ly9Rbk5pcWE2Uw$3d2GkLVg+ycxIWaptbIlF+8f4XB0GUSuiBEs1kBRLLg');
-- VALUES('funcionario');

INSERT INTO users(u_username, u_email, pw_id)
VALUES('funcionario', 'funcionario@gmail.com', 3);

INSERT INTO wallets(w_money)
VALUES(0.00);

INSERT INTO accounts(u_id, ut_id, us_id, w_id)
VALUES(3, 2, 1, 3);

-- 11. Create Admin User
INSERT INTO passwords(pw_hashed_password)
VALUES('$argon2id$v=19$m=65536,t=4,p=1$M0lnZ1duQS5nUi9WbUZNUg$NuefhiF2GS4x7wg37ds1xfIeDEWMu5OOvg3v3DCfemU');
-- VALUES('admin');

INSERT INTO users(u_username, u_email, pw_id)
VALUES('admin', 'admin@gmail.com', 4);

INSERT INTO wallets(w_money)
VALUES(0.00);

INSERT INTO accounts(u_id, ut_id, us_id, w_id)
VALUES(4, 3, 1, 4);

-- === VIEWS ===

-- 1. Get All Users Info
CREATE VIEW get_all_users_info
	AS
SELECT u.u_username AS username, u.u_email AS email , u.u_address AS address, pw.pw_hashed_password AS hashed_password, ut.ut_type AS user_type, us.us_status AS user_status, w.w_money AS money
FROM accounts AS a
INNER JOIN users AS u ON u.u_id = a.u_id
INNER JOIN passwords as pw on pw.pw_id = u.pw_id
INNER JOIN users_types as ut ON ut.ut_id = a.ut_id
INNER JOIN users_status as us ON us.us_id = a.us_id
INNER JOIN wallets as w ON w.w_id = a.w_id;

-- 2. Get All Users
CREATE VIEW get_all_users
	AS
SELECT u.u_username AS username, u.u_email AS email , u.u_address AS address, ut.ut_type AS user_type, us.us_status AS user_status, w.w_money AS money
FROM accounts AS a
INNER JOIN users AS u ON u.u_id = a.u_id
INNER JOIN users_types as ut ON ut.ut_id = a.ut_id
INNER JOIN users_status as us ON us.us_id = a.us_id
INNER JOIN wallets as w ON w.w_id = a.w_id
WHERE us.us_status = 'active';

-- 3. Get All Products
CREATE VIEW get_all_products
	AS
SELECT p.p_name AS product_name, p.p_price AS price, p.p_stock AS stock, p.p_discount AS discount, c.c_name AS category
FROM products AS p
INNER JOIN categories AS c ON c.c_id = p.c_id
INNER JOIN products_status AS ps ON ps.ps_id = p.ps_id
WHERE ps.ps_status = 'active';

-- === FUNCTIONS ===
-- 1. Check If User Exists
DELIMITER $$
CREATE FUNCTION check_user_exists(e VARCHAR(100))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT COUNT(email) FROM get_all_users WHERE email = e);
END $$
DELIMITER ;

-- 2. Get User ID

DELIMITER $$
CREATE FUNCTION get_user_id(e VARCHAR(100))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT u_id FROM users WHERE u_email = e);
END $$
DELIMITER ;

-- === PROCEDURES ===

-- 1. Get User
DELIMITER $$
CREATE PROCEDURE get_user(e VARCHAR(100))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 THEN
		SELECT * FROM get_all_users WHERE email = e;
    END IF;
END $$
DELIMITER ;

-- 2. SignUp

DELIMITER $$
CREATE PROCEDURE create_user(un VARCHAR(150), e VARCHAR(100), pw VARCHAR(255))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 0 THEN
		INSERT INTO passwords(pw_hashed_password)
		VALUES(pw);

		INSERT INTO users(u_username, u_email, pw_id)
		VALUES(un, e, last_insert_id());
        
        SET @userId = last_insert_id();

		INSERT INTO wallets(w_money)
		VALUES(0.00);

		SET @walletId = last_insert_id();

		INSERT INTO accounts(u_id, ut_id, us_id, w_id)
		VALUES(@userId, 1, 1, @walletId);
    END IF;
END $$
DELIMITER ;

-- 3. SignIn

DELIMITER $$
CREATE PROCEDURE sign_in(e VARCHAR(100))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );

	IF @user_exist = 1 THEN
		SELECT hashed_password
		FROM get_all_users_info
		WHERE email = e AND user_status = 'active';
    END IF;
END $$
DELIMITER ;

-- 4. Get Products By Category

DELIMITER $$
CREATE PROCEDURE get_category_products(c VARCHAR(100))
BEGIN
	SELECT * FROM get_all_products WHERE category = c;
END $$
DELIMITER ;

-- 5. Get a Specific Product

DELIMITER $$
CREATE PROCEDURE get_product(pn VARCHAR(100))
BEGIN
	SELECT * FROM get_all_products WHERE product_name = pn;
END $$
DELIMITER ;

-- 6. Get Product Stock

DELIMITER $$
CREATE PROCEDURE get_stock(pn VARCHAR(100))
BEGIN
	SELECT stock FROM get_all_products WHERE product_name = pn;
END $$
DELIMITER ;