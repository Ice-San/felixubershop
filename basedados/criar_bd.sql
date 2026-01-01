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
    ut_type VARCHAR(13) NOT NULL UNIQUE,
    
    ut_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ut_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users_status (
	us_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    us_status VARCHAR(8) NOT NULL UNIQUE,
    
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
    c_name VARCHAR(100) NOT NULL UNIQUE,
    
    c_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    c_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products_status (
	ps_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ps_status VARCHAR(8) UNIQUE,
    
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
    os_status VARCHAR(8) NOT NULL UNIQUE,
    
    os_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    os_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE orders (
	o_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    o_name VARCHAR(125) NOT NULL,
    o_destiny VARCHAR(175) NOT NULL,
    o_arrival_time TIMESTAMP NOT NULL,
    o_total_price DECIMAL(15,2) NOT NULL,
    
    a_id INT NOT NULL,
    os_id INT NOT NULL,
    
    o_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    o_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT o_unique_name UNIQUE (a_id, o_name, o_arrival_time, os_id)
);

CREATE TABLE products_orders (
	po_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    po_quantity INT NOT NULL,
    
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
INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('apple', 3.09, 100, 1, 1);

INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('banana', 1.83, 100, 1, 1);

INSERT INTO products(p_name, p_price, p_stock, p_discount, c_id, ps_id)
VALUES('kiwi', 3.00, 100, 25, 1, 1);

-- VEGETABLES
INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('carrot', 1.00, 100, 2, 1);

INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('broccoli', 3.00, 100, 2, 1);

INSERT INTO products(p_name, p_price, p_stock, p_discount, c_id, ps_id)
VALUES('spinach', 3.50, 100, 25, 2, 1);

-- MEATS
INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('chicken', 6.00, 100, 3, 1);

INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('beef', 12.00, 100, 3, 1);

INSERT INTO products(p_name, p_price, p_stock, p_discount, c_id, ps_id)
VALUES('pork', 3.50, 100, 50, 3, 1);

-- CEREALS
INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('cornflakes', 3.50, 100, 4, 1);

INSERT INTO products(p_name, p_price, c_id, ps_id)
VALUES('oats', 2.50, 4, 1);

INSERT INTO products(p_name, p_price, p_discount, c_id, ps_id)
VALUES('rice krispies', 2.00, 50, 4, 1);

-- WEALTH
INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
VALUES('shampoo', 5.00, 100, 5, 1);

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
VALUES('ongoing');

INSERT INTO orders_status(os_status)
VALUES('pending');

INSERT INTO orders_status(os_status)
VALUES('done');

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
SELECT u.u_username AS username, u.u_email AS email , u.u_address AS address, ut.ut_type AS user_type, us.us_status AS user_status, w.w_money AS money, a.a_created_at AS joined_at
FROM accounts AS a
INNER JOIN users AS u ON u.u_id = a.u_id
INNER JOIN users_types as ut ON ut.ut_id = a.ut_id
INNER JOIN users_status as us ON us.us_id = a.us_id
INNER JOIN wallets as w ON w.w_id = a.w_id;

-- 3. Get All Products
CREATE VIEW get_all_products
	AS
SELECT p.p_name AS product_name, p.p_price AS price, p.p_stock AS stock, p.p_discount AS discount, c.c_name AS category, ps.ps_status AS product_status
FROM products AS p
INNER JOIN categories AS c ON c.c_id = p.c_id
INNER JOIN products_status AS ps ON ps.ps_id = p.ps_id;

-- 4. Get All Orders
CREATE VIEW get_all_orders
	AS
SELECT o.o_name AS order_name, o.o_destiny AS destiny, o.o_arrival_time AS arrival_time, o.o_total_price AS total_price, o.o_created_at AS created_at, os.os_status AS order_status, u.u_email AS owner_email
FROM orders AS o
INNER JOIN orders_status AS os ON os.os_id = o.os_id
INNER JOIN accounts AS a ON o.a_id = a.a_id
INNER JOIN users AS u ON a.u_id = u.u_id;

-- 5. Get all Products from an Order
CREATE VIEW get_all_products_order
	AS
SELECT o.o_name AS order_name, o.o_total_price AS total_price, o.o_arrival_time AS arrival_time, os.os_status AS order_status, p.p_name AS product_name, p.p_price AS product_price, po.po_quantity AS quantity, u.u_email AS owner_email
FROM orders AS o
INNER JOIN orders_status AS os ON os.os_id = o.os_id
INNER JOIN accounts AS a ON o.a_id = a.a_id
INNER JOIN users AS u ON a.u_id = u.u_id
INNER JOIN products_orders AS po ON po.o_id = o.o_id
INNER JOIN products AS p ON p.p_id = po.p_id;

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

-- 3. Check if Product exists

DELIMITER $$
CREATE FUNCTION check_product_exists(pn VARCHAR(175))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT COUNT(product_name) FROM get_all_products WHERE product_name = pn);
END $$
DELIMITER ;

-- 4. Get Product ID

DELIMITER $$
CREATE FUNCTION get_product_id(pn VARCHAR(175))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT p_id FROM products WHERE p_name = pn);
END $$
DELIMITER ;

-- 5. Check if an Order exists

DELIMITER $$
CREATE FUNCTION check_order_exists(e VARCHAR(100), o_name VARCHAR(125))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT COUNT(owner_email) FROM get_all_orders WHERE owner_email = e AND order_name = o_name);
END $$
DELIMITER ;

-- 6. Get Order Id

DELIMITER $$
CREATE FUNCTION get_order_id(e VARCHAR(100), order_name VARCHAR(125), order_status VARCHAR(8))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (
		SELECT o.o_id
		FROM orders AS o
        INNER JOIN orders_status AS os ON os.os_id = o.os_id
		INNER JOIN accounts AS a ON o.a_id = a.a_id
		INNER JOIN users AS u ON a.u_id = u.u_id
        WHERE u.u_email = e AND o.o_name = order_name AND os.os_status = order_status
    );
END $$
DELIMITER ;

-- 7. Get Order Id by Arrival Time

DELIMITER $$
CREATE FUNCTION get_order_id_by_time(e VARCHAR(100), order_name VARCHAR(125), arrival_time TIMESTAMP, order_status VARCHAR(8))
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (
		SELECT o.o_id
		FROM orders AS o
        INNER JOIN orders_status AS os ON os.os_id = o.os_id
		INNER JOIN accounts AS a ON o.a_id = a.a_id
		INNER JOIN users AS u ON a.u_id = u.u_id
        WHERE u.u_email = e AND o.o_name = order_name AND o.o_arrival_time = arrival_time AND os.os_status = order_status
    );
END $$
DELIMITER ;

-- 8. Get FelixUberShop User

DELIMITER $$
CREATE FUNCTION get_felixubershop_user()
RETURNS INT
DETERMINISTIC
BEGIN
	RETURN (SELECT u_id FROM users WHERE u_email = 'felixubershop@gmail.com');
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
		SELECT * FROM get_all_users WHERE email = e AND user_status = 'active';
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

-- 4. Update User

DELIMITER $$
CREATE PROCEDURE update_user(username VARCHAR(75), e VARCHAR(100), pw VARCHAR(255), address VARCHAR(255))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );

	IF @user_exist = 1 THEN
		SET @user_id = (
			SELECT get_user_id(e)
        );
        
        IF username IS NOT NULL AND username != '' THEN
			UPDATE users
			SET u_username = username
			WHERE u_id = @user_id;
        END IF;
        
        IF pw IS NOT NULL AND pw != '' THEN
			SET @pw_id = (
				SELECT pw_id FROM users WHERE u_id = @user_id
            );
        
			UPDATE passwords
			SET pw_hashed_password = pw
			WHERE pw_id = @pw_id;
        END IF;
        
        IF address IS NOT NULL AND address != '' THEN
			UPDATE users
			SET u_address = address
			WHERE u_id = @user_id;
		END IF;
    END IF;
END $$
DELIMITER ;

-- 5. Delete User

DELIMITER $$
CREATE PROCEDURE delete_user(e VARCHAR(100))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 THEN
		SET @user_id = (
			SELECT get_user_id(e)
        );
        
        SET @status_id = (
			SELECT us_id FROM users_status WHERE us_status = 'inactive'
        );
		
		UPDATE accounts SET us_id = @status_id WHERE u_id = @user_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 6. Get all Categories

DELIMITER $$
CREATE PROCEDURE get_categories()
BEGIN
	SELECT c_name AS category_name FROM categories;
END $$
DELIMITER ;

-- 7. Create Special User

DELIMITER $$
CREATE PROCEDURE create_special_user(un VARCHAR(150), e VARCHAR(100), pw VARCHAR(255), user_type VARCHAR(13))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 0 AND user_type IN('admin', 'employee', 'client') THEN
		INSERT INTO passwords(pw_hashed_password)
		VALUES(pw);

		INSERT INTO users(u_username, u_email, pw_id)
		VALUES(un, e, last_insert_id());
        
        SET @userId = last_insert_id();

		INSERT INTO wallets(w_money)
		VALUES(0.00);

		SET @walletId = last_insert_id();
        
        SET @user_type = (
			SELECT ut_id FROM users_types WHERE ut_type = user_type
        );

		INSERT INTO accounts(u_id, ut_id, us_id, w_id)
		VALUES(@userId, @user_type, 1, @walletId);
    END IF;
END $$
DELIMITER ;

-- 8. Get a Specific Product

DELIMITER $$
CREATE PROCEDURE get_product(pn VARCHAR(100))
BEGIN
	SELECT * FROM get_all_products WHERE product_name = pn AND product_status = 'active';
END $$
DELIMITER ;

-- 9. Get Product Stock

DELIMITER $$
CREATE PROCEDURE get_stock(pn VARCHAR(100))
BEGIN
	SELECT stock FROM get_all_products WHERE product_name = pn;
END $$
DELIMITER ;

-- 10. Create Product
DELIMITER $$
CREATE PROCEDURE create_product(pn VARCHAR(175), price DECIMAL(15, 2), stock INT, category_name VARCHAR(100))
BEGIN
	SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    IF @product_exist = 0 THEN
		SET @category_id = (
			SELECT c_id FROM categories WHERE c_name = category_name
		);
        
        SET @status_id = (
			SELECT ps_id FROM products_status WHERE ps_status = 'active'
		);
    
		INSERT INTO products(p_name, p_price, p_stock, c_id, ps_id)
        VALUES(pn, price, stock, @category_id, @status_id);
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 11. Update Product

DELIMITER $$
CREATE PROCEDURE update_product(pn VARCHAR(175), price DECIMAL(15, 2), stock INT, discount INT, category_name VARCHAR(100))
BEGIN
	SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    IF @product_exist = 1 THEN
		SET @product_id = (
			SELECT get_product_id(pn)
        );
    
		IF pn IS NOT NULL AND pn != '' THEN
			UPDATE products SET p_name = pn WHERE p_id = @product_id;
        END IF;
        
        IF stock IS NOT NULL THEN
			UPDATE products SET p_stock = stock WHERE p_id = @product_id;
        END IF;
        
        SET @is_price_set = 0;
        
        IF discount IS NOT NULL AND discount IN(0, 25, 50, 75, 90) THEN
			UPDATE products SET p_discount = discount WHERE p_id = @product_id;
            
            IF price IS NOT NULL AND price != '' AND discount > 0 THEN
				UPDATE products 
				SET p_price = price * (1 - (discount / 100)) 
				WHERE p_id = @product_id;
                
                SET @is_price_set = 1;
			END IF;
        END IF;
        
        IF price IS NOT NULL AND price != '' AND @is_price_set = 0 THEN
			UPDATE products SET p_price = price WHERE p_id = @product_id;
        END IF;
        
        IF category_name IS NOT NULL AND category_name != '' THEN
			SET @category_id = (
				SELECT c_id FROM categories WHERE c_name = category_name
            );
        
			UPDATE products SET c_id = @category_id WHERE p_id = @product_id;
        END IF;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 12. Delete Product

DELIMITER $$
CREATE PROCEDURE delete_product(pn VARCHAR(175))
BEGIN
	SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    IF @product_exist = 1 THEN
		SET @product_id = (
			SELECT get_product_id(pn)
        );
        
        SET @status_id = (
			SELECT ps_id FROM products_status WHERE ps_status = 'inactive'
        );
		
		UPDATE products SET ps_id = @status_id WHERE p_id = @product_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 13. Get Orders

DELIMITER $$
CREATE PROCEDURE get_orders()
BEGIN
	SELECT * 
    FROM get_all_orders 
    WHERE order_status = 'ongoing' OR order_status = 'done'
    ORDER BY order_status DESC;
END $$
DELIMITER ;

-- 14. Get all Orders from an User

DELIMITER $$
CREATE PROCEDURE get_user_orders(e VARCHAR(100))
BEGIN
	SELECT * FROM get_all_orders 
    WHERE order_status = 'ongoing' AND owner_email = e;
END $$
DELIMITER ;

-- 15. Get Products from an Order

DELIMITER $$
CREATE PROCEDURE get_products_order(e VARCHAR(100), o_name VARCHAR(125), o_status VARCHAR(8), o_arrival_time TIMESTAMP)
BEGIN
	SELECT * FROM get_all_products_order 
    WHERE owner_email = e AND order_name = o_name AND order_status = o_status AND arrival_time = o_arrival_time;
END $$
DELIMITER ;

-- 16. Add Product to an Order

DELIMITER $$
CREATE PROCEDURE add_product(pn VARCHAR(175), e VARCHAR(100), order_name VARCHAR(125), order_status VARCHAR(8))
BEGIN
	SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    SET @product_id = (
		SELECT p_id FROM products WHERE p_name = pn
	);
    
    IF @product_exist = 1 AND order_status = 'pending' THEN
		SET @product_price = (
				SELECT p_price FROM products WHERE p_name = pn
        );
    
		SET @order_exist = (
			SELECT check_order_exists(e, 'order1')
		);

		IF @order_exist = 0 THEN
			SET @order_status_id = (
				SELECT os_id FROM orders_status WHERE os_status = order_status
            );
            
            SET @user_id = (
				SELECT get_user_id(e)
            );
        
			INSERT INTO orders(o_name, o_destiny, o_arrival_time, o_total_price, a_id, os_id) 
			VALUES('order1', 'unset destiny', NOW() + INTERVAL 5 HOUR, @product_price, @user_id, @order_status_id);
            
            INSERT INTO products_orders(o_id, p_id, po_quantity)
            VALUES(last_insert_id(), @product_id, 1);
		END IF;
        
        IF @order_exist = 1 AND e IS NOT NULL AND e != '' THEN
			SET @order_id = (
				SELECT get_order_id(e, 'order1', order_status)
            );
            
            SET @order_product_exist = (
				SELECT COUNT(*) FROM products_orders WHERE o_id = @order_id AND p_id = @product_id
            );
            
            SET @product_price = (
				SELECT p_price FROM products WHERE p_id = @product_id
            );
            
            SET @total_price = (
				SELECT o_total_price FROM orders WHERE o_id = @order_id
            );
            
			UPDATE orders
			SET o_total_price = @total_price + @product_price
			WHERE o_id = @order_id;
            
            IF @order_product_exist > 0 THEN
				UPDATE products_orders
				SET po_quantity = po_quantity + 1
				WHERE o_id = @order_id AND p_id = @product_id;
            ELSE
				INSERT INTO products_orders(o_id, p_id, po_quantity)
				VALUES(@order_id, @product_id, 1);
            END IF;
        END IF;
    END IF;
    
    IF @product_exist = 1 AND order_status = 'ongoing' AND order_name IS NOT NULL AND order_name != '' THEN
		SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
		
		SET @order_product_exist = (
			SELECT COUNT(*) FROM products_orders WHERE o_id = @order_id AND p_id = @product_id
		);
		
		SET @product_price = (
			SELECT p_price FROM products WHERE p_id = @product_id
		);
		
		SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
		
		UPDATE orders
		SET o_total_price = @total_price + @product_price
		WHERE o_id = @order_id;
		
		IF @order_product_exist > 0 THEN
			UPDATE products_orders
			SET po_quantity = po_quantity + 1
			WHERE o_id = @order_id AND p_id = @product_id;
		ELSE
			INSERT INTO products_orders(o_id, p_id, po_quantity)
			VALUES(@order_id, @product_id, 1);
		END IF;
        
        SET @user_exist = (
			SELECT check_user_exists(e)
		);
        
        IF @user_exist = 1 THEN
            SET @felixubershop_wallet_id = (
				SELECT w_id FROM accounts WHERE u_id = @felixubershop_id
			);
			
			UPDATE wallets
			SET w_money = w_money + @product_price
			WHERE w_id = @felixubershop_wallet_id;
			
			SET @user_id = (
				SELECT get_user_id(e)
			);
			
			SET @user_wallet_id = (
				SELECT w_id FROM accounts WHERE u_id = @user_id
			);
			
			UPDATE wallets
			SET w_money = w_money - @product_price
			WHERE w_id = @user_wallet_id;
        END IF;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 17. Set Order to On Going

DELIMITER $$
CREATE PROCEDURE ongoing_order(e VARCHAR(100), order_name VARCHAR(125), destiny VARCHAR(175))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    SET @user_id = (
		SELECT get_user_id(e)
	);
    
    SET @order_id = (
		SELECT get_order_id(e, 'order1', 'pending')
	);
    
    SET @check_stock = (
		SELECT COUNT(*)
		FROM products as p
		INNER JOIN products_orders as po ON po.p_id = p.p_id
		WHERE po.o_id = @order_id AND p.p_stock < po.po_quantity
	);
    
    IF @user_exist = 1 AND order_name IS NOT NULL AND order_name != '' AND order_name != 'order1' AND @check_stock = 0 THEN
        SET @wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
        );
        
        SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
        );
        
        UPDATE wallets
        SET w_money = w_money - @total_price
        WHERE w_id = @wallet_id;
        
		UPDATE products as p
		INNER JOIN products_orders AS po ON po.p_id = p.p_id
		SET p.p_stock = p.p_stock - po.po_quantity
		WHERE po.o_id = @order_id;
        
        SET @status_id = (
			SELECT os_id FROM orders_status WHERE os_status = 'ongoing'
        );
        
        IF destiny IS NOT NULL AND destiny != '' THEN
			UPDATE orders
			SET os_id = @status_id, 
				o_name = order_name,
				o_destiny = destiny
			WHERE o_id = @order_id;
		END IF;
        
        IF destiny IS NULL AND destiny = '' THEN
			SET @address = (
				SELECT u_address FROM users WHERE u_id = @user_id
            );
            
            IF @address IS NOT NULL AND @address != '' THEN
				UPDATE orders
				SET os_id = @status_id, 
					o_name = order_name,
					o_destiny = @address
				WHERE o_id = @order_id;
            END IF;
		END IF;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 18. Remove a Product from an Order

DELIMITER $$
CREATE PROCEDURE remove_product(e VARCHAR(100), pn VARCHAR(175), order_name VARCHAR(125), order_status VARCHAR(8))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    SET @order_exist = (
		SELECT check_order_exists(e, order_name)
    );
    
    SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    IF @user_exist = 1 AND @order_exist = 1 AND @product_exist = 1 AND order_status = 'pending' THEN
        SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
		
		SET @product_id = (
			SELECT get_product_id(pn)
		);
            
		SET @product_price = (
			SELECT p_price FROM products WHERE p_id = @product_id
		);
		
		SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
		
		UPDATE orders
		SET o_total_price = @total_price - @product_price
		WHERE o_id = @order_id;
        
        DELETE FROM products_orders
        WHERE o_id = @order_id AND p_id = @product_id;
    END IF;
    
    IF @user_exist = 1 AND @order_exist = 1 AND @product_exist = 1 AND order_status = 'ongoing' AND order_name IS NOT NULL AND order_name != '' THEN
		 SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
		
		SET @product_id = (
			SELECT get_product_id(pn)
		);
            
		SET @product_price = (
			SELECT p_price FROM products WHERE p_id = @product_id
		);
		
		SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
		
		UPDATE orders
		SET o_total_price = @total_price - @product_price
		WHERE o_id = @order_id;
        
        DELETE FROM products_orders
        WHERE o_id = @order_id AND p_id = @product_id;
        
        SET @felixubershop_id = (
			SELECT get_felixubershop_user()
		);
		
		SET @felixubershop_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @felixubershop_id
		);
		
		SET @felixubershop_money = (
			SELECT w_money FROM wallets WHERE w_id = @felixubershop_wallet_id
		);
		
		IF @felixubershop_money >= @product_price THEN
			UPDATE wallets
			SET w_money = w_money - @product_price
			WHERE w_id = @felixubershop_wallet_id;
		END IF;
		
		SET @user_id = (
			SELECT get_user_id(e)
		);
		
		SET @user_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
		);
		
		UPDATE wallets
		SET w_money = w_money + @product_price
		WHERE w_id = @user_wallet_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 19. Remove Product Quantity from an Order

DELIMITER $$
CREATE PROCEDURE remove_product_quantity(e VARCHAR(100), pn VARCHAR(175), order_name VARCHAR(125), order_status VARCHAR(8))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    SET @order_exist = (
		SELECT check_order_exists(e, order_name)
    );
    
    SET @product_exist = (
		SELECT check_product_exists(pn)
    );
    
    IF @user_exist = 1 AND @order_exist = 1 AND @product_exist = 1 AND order_status = 'pending' THEN
        SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
		
		SET @product_id = (
			SELECT get_product_id(pn)
		);
            
		SET @product_price = (
			SELECT p_price FROM products WHERE p_id = @product_id
		);
		
		SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
		
		UPDATE orders
		SET o_total_price = @total_price - @product_price
		WHERE o_id = @order_id;
        
        UPDATE products_orders
        SET po_quantity = po_quantity - 1
        WHERE o_id = @order_id AND p_id = @product_id;
    END IF;
    
    IF @user_exist = 1 AND @order_exist = 1 AND @product_exist = 1 AND order_status = 'ongoing' AND order_name IS NOT NULL AND order_name != '' THEN
		 SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
		
		SET @product_id = (
			SELECT get_product_id(pn)
		);
            
		SET @product_price = (
			SELECT p_price FROM products WHERE p_id = @product_id
		);
		
		SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
		
		UPDATE orders
		SET o_total_price = @total_price - @product_price
		WHERE o_id = @order_id;
        
        UPDATE products_orders
        SET po_quantity = po_quantity - 1
        WHERE o_id = @order_id AND p_id = @product_id;
    
		SET @felixubershop_id = (
			SELECT get_felixubershop_user()
		);
		
		SET @felixubershop_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @felixubershop_id
		);
		
		SET @felixubershop_money = (
			SELECT w_money FROM wallets WHERE w_id = @felixubershop_wallet_id
		);
		
		IF @felixubershop_money >= @product_price THEN
			UPDATE wallets
			SET w_money = w_money - @product_price
			WHERE w_id = @felixubershop_wallet_id;
		END IF;
		
		SET @user_id = (
			SELECT get_user_id(e)
		);
		
		SET @user_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
		);
		
		UPDATE wallets
		SET w_money = w_money + @product_price
		WHERE w_id = @user_wallet_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 20. Update Order

DELIMITER $$
CREATE PROCEDURE update_order(e VARCHAR(100), order_name VARCHAR(125), order_status VARCHAR(8), new_order_name VARCHAR(125), new_arrival_time TIMESTAMP)
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    SET @order_exist = (
		SELECT check_order_exists(e, order_name)
    );
    
    IF @user_exist = 1 AND @order_exist = 1 THEN
        SET @order_id = (
			SELECT get_order_id(e, order_name, order_status)
		);
        
        IF order_name != new_order_name AND new_order_name IS NOT NULL AND new_order_name != '' THEN
			UPDATE orders
			SET o_name = new_order_name
            WHERE o_id = @order_id;
		END IF;
        
        IF new_arrival_time IS NOT NULL THEN
			UPDATE orders
			SET o_arrival_time = new_arrival_time
            WHERE o_id = @order_id;
		END IF;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 21. Set Order to Done

DELIMITER $$
CREATE PROCEDURE done_order(e VARCHAR(100), order_name VARCHAR(125))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 AND order_name IS NOT NULL AND order_name != '' THEN
		SET @order_id = (
			SELECT get_order_id(e, order_name, 'ongoing')
        );
        
        SET @status_id = (
			SELECT os_id FROM orders_status WHERE os_status = 'done'
        );
        
        UPDATE orders
        SET os_id = @status_id, o_name = order_name
        WHERE o_id = @order_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 22. Delete Order

DELIMITER $$
CREATE PROCEDURE delete_order(e VARCHAR(100), order_name VARCHAR(125), arrival_time TIMESTAMP, order_status VARCHAR(8))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 AND order_name IS NOT NULL AND order_name != '' THEN
		SET @order_id = (
			SELECT get_order_id_by_time(e, order_name, arrival_time, order_status)
        );
        
        SET @status_id = (
			SELECT os_id FROM orders_status WHERE os_status = 'inactive'
        );
        
        UPDATE orders
        SET os_id = @status_id, o_name = order_name
        WHERE o_id = @order_id;
        
        SET @total_price = (
			SELECT o_total_price FROM orders WHERE o_id = @order_id
		);
        
        SET @felixubershop_id = (
			SELECT get_felixubershop_user()
		);
		
		SET @felixubershop_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @felixubershop_id
		);
		
		SET @felixubershop_money = (
			SELECT w_money FROM wallets WHERE w_id = @felixubershop_wallet_id
		);
		
		IF @felixubershop_money >= @total_price THEN
			UPDATE wallets
			SET w_money = w_money - @product_price
			WHERE w_id = @felixubershop_wallet_id;
		END IF;
		
		SET @user_id = (
			SELECT get_user_id(e)
		);
		
		SET @user_wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
		);
		
		UPDATE wallets
		SET w_money = w_money + @total_price
		WHERE w_id = @user_wallet_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 23. Update User Money

DELIMITER $$
CREATE PROCEDURE update_user_money(e VARCHAR(100), money DECIMAL(15,2))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 THEN
		SET @user_id = (
			SELECT get_user_id(e)
        );
        
        SET @wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
        );
        
        UPDATE wallets
        SET w_money = w_money + money
        WHERE w_id = @wallet_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 24. Remove User Money

DELIMITER $$
CREATE PROCEDURE delete_user_money(e VARCHAR(100))
BEGIN
	SET @user_exist = (
		SELECT check_user_exists(e)
    );
    
    IF @user_exist = 1 THEN
		SET @user_id = (
			SELECT get_user_id(e)
        );
        
        SET @wallet_id = (
			SELECT w_id FROM accounts WHERE u_id = @user_id
        );
        
        UPDATE wallets
        SET w_money = 0
        WHERE w_id = @wallet_id;
    END IF;
    
    IF ROW_COUNT() > 0 THEN
        SELECT 1 AS is_success;
    ELSE
        SELECT 0 AS is_success;
    END IF;
END $$
DELIMITER ;

-- 25. Get User History Orders

DELIMITER $$
CREATE PROCEDURE get_done_orders(e VARCHAR(100))
BEGIN
	SELECT destiny, arrival_time, created_at FROM get_all_orders 
    WHERE order_status = 'done' AND owner_email = e;
END $$
DELIMITER ;

-- 26. Get Cart

DELIMITER $$
CREATE PROCEDURE get_pending_orders(e VARCHAR(100))
BEGIN
	SELECT order_name, total_price, arrival_time FROM get_all_orders 
    WHERE order_status = 'pending' AND owner_email = e;
END $$
DELIMITER ;