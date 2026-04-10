CREATE DATABASE BL;
USE BL;
CREATE USER IF NOT EXISTS'training_user'@'localhost' IDENTIFIED BY 'training_pass';
GRANT ALL PRIVILEGES ON BL.* TO 'training_user'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE Address(
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

ALTER TABLE address
MODIFY COLUMN address_id INT NOT NULL UNIQUE;

ALTER TABLE address
MODIFY COLUMN id CHAR(36) NOT NULL;

CREATE TABLE addressDefaultInstruction (
	address_id CHAR(36) NOT NULL,
	customer_id CHAR(36) NOT NULL,
    deliveryInstruction TEXT NOT NULL,
    packingInstruction TEXT NOT NULL,
    CONSTRAINT fk_addressDefaultInstruction_1
    FOREIGN KEY (address_id) REFERENCES address(id),
    CONSTRAINT fk_addressDefaultInstruction_2
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM addressDefaultInstruction;
DESCRIBE addressDefaultInstruction;

ALTER TABLE addressDefaultInstruction
MODIFY COLUMN address_id CHAR(36) DEFAULT NULL UNIQUE; 

ALTER TABLE addressDefaultInstruction
ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY NOT NULL; 

DELETE FROM addressDefaultInstruction 
WHERE id = 2;

ALTER TABLE addressDefaultInstruction
DROP COLUMN id;

CREATE TABLE addressString(
	id INT NOT NULL PRIMARY KEY UNIQUE,
	address_id CHAR(36) NOT NULL,
	customer_id CHAR(36) NOT NULL,
    text TEXT NOT NULL,
    dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
    lastModified DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_addressString_1
    FOREIGN KEY (address_id) REFERENCES address(id),
    CONSTRAINT fk_addressString_2
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM addressString;
DESCRIBE addressString;

CREATE TABLE addressToDeliveryRunMapping (
	id INT NOT NULL PRIMARY KEY UNIQUE,
    addressType VARCHAR(100) NOT NULL,
    address_id CHAR(36) NOT NULL,
	customer_id CHAR(36) NOT NULL,
    product_id CHAR(36) NOT NULL,
	deliveryRun_id CHAR(36) NOT NULL,
    carrier_id INT NOT NULL,
    flowDirection VARCHAR(100) NOT NULL,
    CONSTRAINT fk_addressToDeliveryRunMapping_1
	FOREIGN KEY (address_id) REFERENCES address(id),
	CONSTRAINT fk_addressToDeliveryRunMapping_2
	FOREIGN KEY (customer_id) REFERENCES customer(id),
	CONSTRAINT fk_addressToDeliveryRunMapping_3
	FOREIGN KEY (product_id) REFERENCES product(id),
	CONSTRAINT fk_addressToDeliveryRunMapping_4
	FOREIGN KEY (deliveryRun_id) REFERENCES deliveryRun(id),
	CONSTRAINT fk_addressToDeliveryRunMapping_5
	FOREIGN KEY (carrier_id) REFERENCES carrier(id)
);
SELECT * FROM addressToDeliveryRunMapping;
DESCRIBE addressToDeliveryRunMapping;

CREATE TABLE addressToInvoiceCustomerMapping (
	id INT NOT NULL PRIMARY KEY UNIQUE,
	customer_id CHAR(36) NOT NULL,
    address_id CHAR(36) NOT NULL
);
SELECT * FROM addressToInvoiceCustomerMapping;
DESCRIBE addressToInvoiceCustomerMapping;

CREATE TABLE deliveryAddressToOnforwarderAddressMapping (
	id INT NOT NULL PRIMARY KEY UNIQUE,
	address_id CHAR(36) NOT NULL,
	customer_id CHAR(36) NOT NULL,
	product_id CHAR(36) NOT NULL,
	CONSTRAINT fk_deliveryAddressToOnforwarderAddressMapping_1
	FOREIGN KEY (address_id) REFERENCES address(id),
	CONSTRAINT fk_deliveryAddressToOnforwarderAddressMapping_2
	FOREIGN KEY (customer_id) REFERENCES customer(id),
	CONSTRAINT fk_deliveryAddressToOnforwarderAddressMapping_3
	FOREIGN KEY (product_id) REFERENCES product(id)
);
SELECT * FROM deliveryAddressToOnforwarderAddressMapping;
DESCRIBE deliveryAddressToOnforwarderAddressMapping;

CREATE TABLE carrier(
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    carrier_name VARCHAR(100) NOT NULL,
    on_forwarder BOOL NOT NULL,
    status VARCHAR(100) NOT NULL
);
SELECT * FROM carrier;
DESCRIBE carrier;

INSERT INTO carrier (carrier_name, on_forwarder, status)
VALUES ("Brisbane Logistics", 2, 1);

CREATE TABLE Contact(
	id CHAR(36) PRIMARY KEY NOT NULL,
    customer_id CHAR(36) NULL,
    contact_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
	phone VARCHAR(50) NOT NULL,
	CONSTRAINT fk_contact
    FOREIGN KEY (customer_id) REFERENCES Customer(id)
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

ALTER TABLE customer
MODIFY COLUMN id CHAR(36) NOT NULL;

CREATE TABLE Invoice(
	id CHAR(36) NOT NULL PRIMARY KEY, 
    invoice_id INT DEFAULT NULL UNIQUE,
    customer_id CHAR(36) DEFAULT NULL,
    rateCard_id INT NOT NULL,
    manifest_id INT NOT NULL,
    income FLOAT NOT NULL,
    expense FLOAT NOT NULL,
    startDate DATE NOT NULL DEFAULT (CURRENT_DATE),
    endDate DATE NOT NULL DEFAULT (CURRENT_DATE),
	status VARCHAR(50) NOT NULL,
    paymentStatus VARCHAR(100) NOT NULL,
    emailStatus VARCHAR(100) NOT NULL,
    internalReference VARCHAR(100) NOT NULL,
    externalReference VARCHAR(100) NOT NULL,
    CONSTRAINT fk_invoice_1
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    CONSTRAINT fk_invoice_2
    FOREIGN KEY (rateCard_id) REFERENCES rateCard(id),
    CONSTRAINT fk_invoice_3
    FOREIGN KEY (manifest_id) REFERENCES manifest(id)
);
SELECT * FROM Invoice;
DESCRIBE Invoice;

CREATE TABLE rateCard(
	id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id CHAR(36) DEFAULT NULL,
    rates VARCHAR(50) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    CONSTRAINT fk_rateCard
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM rateCard;
DESCRIBE rateCard;

INSERT INTO rateCard (customer_id, rates, contact_email)
VALUES ('64ed8b3e-3247-11f1-92ef-00249b8cd187', 10.50, "test@gmail.com");

CREATE TABLE manifest(
	id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id CHAR(36) DEFAULT NULL,
    dateAdded DATETIME NOT NULL,
    customerReference DATE NOT NULL,
    noOfPallets VARCHAR(100) NOT NULL,
    info VARCHAR(100) NOT NULL,
    requires_pickup BOOL NOT NULL,
    comments VARCHAR(255) NOT NULL,
	CONSTRAINT fk_manifest
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM manifest;
DESCRIBE manifest;

INSERT INTO manifest (customer_id, dateAdded, customerReference, noOfPallets, info, requires_pickup, comments)
VALUES ('64ed8b3e-3247-11f1-92ef-00249b8cd187', NOW(), "2026-4-8", "Not Specified", "In Warehouse (Pickup)", 1, "");

CREATE TABLE Product(
	id CHAR(36) NOT NULL PRIMARY KEY,
    product_id INT DEFAULT NULL UNIQUE,
    customer_id CHAR(36) DEFAULT NULL,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    sku VARCHAR(100) NOT NULL UNIQUE,
    orderDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    unitOfMeasure VARCHAR(100) NOT NULL,
    width DECIMAL(10,2) NOT NULL,
    length DECIMAL(10,2) NOT NULL,
    height DECIMAL(10,2) NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_product
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM Product;
DESCRIBE Product;

CREATE TABLE Consignment(
	id CHAR(36) NOT NULL PRIMARY KEY,
    consignment_id INT DEFAULT NULL UNIQUE,
    saleOrder_id CHAR(36) DEFAULT NULL,
    address_id CHAR(36) DEFAULT NULL,
    product_id CHAR(36) DEFAULT NULL,
    deliveryRun_id CHAR(36) DEFAULT NULL,
    driver_id CHAR(36) DEFAULT NULL,
    runsheet_id INT NULL,
    service VARCHAR(100) NOT NULL,
    reference VARCHAR(100) NOT NULL,
    is_residential BOOL NOT NULL,
    quantity INT NOT NULL,
    cubic FLOAT NOT NULL,
    weight FLOAT NOT NULL,
    pallets FLOAT NOT NULL,
    spaces FLOAT NOT NULL,
    CONSTRAINT fk_consignment_1
    FOREIGN KEY (saleOrder_id) REFERENCES saleOrder(id),
    CONSTRAINT fk_consignment_2
    FOREIGN KEY (address_id) REFERENCES address(id),
    CONSTRAINT fk_consignment_3
    FOREIGN KEY (product_id) REFERENCES product(id),
    CONSTRAINT fk_consignment_4
    FOREIGN KEY (deliveryRun_id) REFERENCES deliveryRun(id),
    CONSTRAINT fk_consignment_5
    FOREIGN KEY (driver_id) REFERENCES driver(id),
    CONSTRAINT fk_consignment_6
    FOREIGN KEY (runsheet_id) REFERENCES runsheet(id)
);
SELECT * FROM Consignment;
DESCRIBE Consignment;

CREATE TABLE saleOrder(
    id CHAR(36) NOT NULL PRIMARY KEY,
    saleOrder_id INT DEFAULT NULL UNIQUE,
    customer_id CHAR(36) DEFAULT NULL,
    orderReference VARCHAR(100) NOT NULL,
    custReference VARCHAR(100) NOT NULL,
    shipName VARCHAR(255) NOT NULL,
    shipAddress TEXT NOT NULL,
    orderDate DATE NOT NULL DEFAULT (CURRENT_DATE),
    lineItems JSON NOT NULL,
    orderStatus VARCHAR(50) NOT NULL,
    shipInstructions TEXT NOT NULL,
    trackingCarrier VARCHAR(100) NOT NULL,
    trackingNumber VARCHAR(100) NOT NULL,
    shipMethod VARCHAR(100) NOT NULL,
    isUrgent BOOL NOT NULL,
    isInvoiced BOOL NOT NULL,
    packer VARCHAR(100) NOT NULL,
    history JSON NOT NULL,
    charges JSON NOT NULL,
    consignments JSON NOT NULL,
    errors JSON NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_saleOrder
	FOREIGN KEY (customer_id) REFERENCES Customer(id)
);
SELECT * FROM saleOrder;
DESCRIBE saleOrder;

INSERT INTO saleOrder (
    id,
    saleOrder_id,
    customer_id,
    orderReference,
    custReference,
    shipName,
    shipAddress,
    lineItems,
    orderStatus,
    shipInstructions,
    trackingCarrier,
    trackingNumber,
    shipMethod,
    isUrgent,
    isInvoiced,
    packer,
    history,
    charges,
    consignments,
    errors
) VALUES (
    UUID(),
    1001,
    '64ed8b3e-3247-11f1-92ef-00249b8cd187',
    'SO-100001',
    'CR-556677',
    'Alexandra Boyles',
    '123 Main Street, Talisay City, Cebu, Philippines',
    JSON_ARRAY(
        JSON_OBJECT(
            'product_id', 567,
            'name', 'Office Chair',
            'qty', 2,
            'price', 4500.00
        )
    ),
    'Processing',
    'Leave at front desk',
    'LBC',
    'LBC123456789',
    'Ground',
    1,
    0,
    'John Packer',
    JSON_ARRAY(
        JSON_OBJECT(
            'status', 'Created',
            'timestamp', '2026-04-08 09:00:00'
        )
    ),
    JSON_OBJECT(
        'subtotal', 9000.00,
        'shipping', 500.00,
        'tax', 1080.00,
        'total', 10580.00
    ),
    JSON_ARRAY(),
    JSON_ARRAY()
);

CREATE TABLE deliveryRun(
    id CHAR(36) NOT NULL PRIMARY KEY,
    deliveryRun_name VARCHAR(100) NOT NULL,
    carrier VARCHAR(100) NOT NULL
);
SELECT * FROM deliveryRun;
DESCRIBE deliveryRun;

INSERT INTO deliveryRun (
    id,
    deliveryRun_name,
    carrier
) VALUES (
    UUID(),
    'Cebu South Route',
    'LBC'
);

CREATE TABLE driver(
    id CHAR(36) NOT NULL PRIMARY KEY,
    driver_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    is_online BOOL NOT NULL,
    location_access_available BOOL NOT NULL
);
SELECT * FROM driver;
DESCRIBE driver;

INSERT INTO driver (
    id,
    driver_name,
    email,
    is_online,
    location_access_available
) VALUES (
    UUID(),
    'Juan Dela Cruz',
    'juan.delacruz@example.com',
    1,
    1
);

CREATE TABLE runsheet(
    id INT AUTO_INCREMENT PRIMARY KEY,
    deliveryRun_id CHAR(36) DEFAULT NULL,
    driver_id CHAR(36) DEFAULT NULL,
    runsheet_name VARCHAR(100) NOT NULL,
    totalCashOnDelivery DECIMAL(10,2) NOT NULL,
    income DECIMAL(10,2) NOT NULL,
    is_complete BOOL NOT NULL,
    CONSTRAINT fk_runsheet_1
	FOREIGN KEY (deliveryRun_id) REFERENCES deliveryRun(id),
    CONSTRAINT fk_runsheet_2
	FOREIGN KEY (driver_id) REFERENCES driver(id)
);
SELECT * FROM runsheet;
DESCRIBE runsheet;

INSERT INTO runsheet (
    deliveryRun_id,
    driver_id,
    runsheet_name,
    totalCashOnDelivery,
    income,
    is_complete
) VALUES (
    '222e8400-e29b-41d4-a716-222222222222',
    '333e8400-e29b-41d4-a716-333333333333',
    'Runsheet - April 8 AM',
    10580.00,
    1200.00,
    0
);

CREATE TABLE PurchaseOrder(
    id CHAR(36) NOT NULL PRIMARY KEY,
    purchase_order_id INT DEFAULT NULL UNIQUE,
    customer_id CHAR(36) NOT NULL,
    order_reference VARCHAR(100) NOT NULL,
    cust_reference VARCHAR(100) NOT NULL,
    ship_name VARCHAR(100) NOT NULL,
    ship_address VARCHAR(255) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL,
    CONSTRAINT fk_purchase_order
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
SELECT * FROM PurchaseOrder;
DESCRIBE PurchaseOrder;
