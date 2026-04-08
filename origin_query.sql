CREATE DATABASE BL;
USE BL;
CREATE USER IF NOT EXISTS'training_user'@'localhost' IDENTIFIED BY 'training_pass';
GRANT ALL PRIVILEGES ON BL.* TO 'training_user'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE Address (
 id CHAR(36) PRIMARY KEY,
 address_id INT NOT NULL,
 street_1 VARCHAR(100) NOT NULL,
 street_2 VARCHAR(100) NOT NULL,
 suburb VARCHAR(100) NOT NULL,
 state VARCHAR(100) NOT NULL,
 postcode VARCHAR(50) NOT NULL
);
SELECT * FROM Address;
DESCRIBE Address;

INSERT INTO Address (id, address_id, street_1, street_2, suburb, state, postcode)
VALUE (UUID(), 12345, "5th Avenue", "Keren", "MELBOURNE", "Victoria", "Australia");

CREATE TABLE Contact (
	id CHAR(36) PRIMARY KEY,
    customer_id CHAR(36) NULL,
    FOREIGN KEY (customer_id) REFERENCES Customer(id),
    contact_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
	phone VARCHAR(50) NOT NULL
);
SELECT * FROM Contact;
DESCRIBE Contact;

CREATE TABLE Customer(
	id CHAR(36) PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
	contact_phone VARCHAR(50) NOT NULL,
	contact_email VARCHAR(100) NOT NULL
);
SELECT * FROM Customer;
DESCRIBE Customer;

INSERT INTO Customer (id, customer_name, contact_phone, contact_email)
VALUES (UUID(), "Test", "09123456789", "test@gmail.com");