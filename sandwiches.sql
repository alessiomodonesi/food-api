CREATE DATABASE sandwiches;
USE sandwiches;

-- tabelle principali

CREATE TABLE account(
ID INT AUTO_INCREMENT PRIMARY KEY,
name NVARCHAR(32) NOT NULL,
surname NVARCHAR(32) NOT NULL,
email NVARCHAR(64) UNIQUE NOT NULL,
password NVARCHAR(32) NOT NULL,
active BIT DEFAULT 1
);

CREATE TABLE category(
ID INT AUTO_INCREMENT PRIMARY KEY,
name NVARCHAR(16) NOT NULL,
iva_tax DECIMAL(10,2) NOT NULL,
CHECK (iva_tax > 0)
);

CREATE TABLE nutritional_value(
ID INT AUTO_INCREMENT PRIMARY KEY,
kcal INT NOT NULL,
fats DECIMAL(10,2) NOT NULL,
saturated_fats DECIMAL(10,2),
carbohydrates DECIMAL(10,2) NOT NULL,
sugars DECIMAL(10,2),
proteins DECIMAL(10,2) NOT NULL,
salt DECIMAL(10,2),
fiber DECIMAL(10,2),
CHECK (kcal > 0),
CHECK (fats >= 0),
CHECK (carbohydrates >= 0),
CHECK (proteins >= 0)
);

CREATE TABLE product(
ID INT AUTO_INCREMENT PRIMARY KEY,
name NVARCHAR(32) NOT NULL,
price DECIMAL(3,2) NOT NULL,
description NVARCHAR(128),
category_ID INT NOT NULL,
quantity INT NOT NULL,
nutritional_value_ID INT NOT NULL,
CHECK (price > 0),
CHECK (quantity > 0),
FOREIGN KEY (category_ID) REFERENCES category(ID),
FOREIGN KEY (nutritional_value_ID) REFERENCES nutritional_value(ID)
);

CREATE TABLE ingredient(
ID INT AUTO_INCREMENT PRIMARY KEY,
name NVARCHAR(32) NOT NULL,
description NVARCHAR(128),
available_quantity DECIMAL(10,2) NOT NULL,
CHECK (available_quantity >= 0)
);

CREATE TABLE cart(
ID INT AUTO_INCREMENT PRIMARY KEY,
user_ID INT NOT NULL,
total_price DECIMAL(10,2) NOT NULL,
CHECK (total_price > 0),
FOREIGN KEY (user_ID) REFERENCES account(ID)
);

CREATE TABLE status(
ID INT AUTO_INCREMENT PRIMARY KEY,
description NVARCHAR(16) NOT NULL
);

CREATE TABLE break(
ID INT AUTO_INCREMENT PRIMARY KEY,
break_time TIME NOT NULL
);

CREATE TABLE pickup_point(
ID INT AUTO_INCREMENT PRIMARY KEY,
description NVARCHAR(64) NOT NULL
);

CREATE TABLE user_order(
ID INT AUTO_INCREMENT PRIMARY KEY,
user_ID INT NOT NULL,
total_price DECIMAL(10,2) NOT NULL,
date_hour_sale DATETIME NOT NULL DEFAULT current_timestamp,
break_ID INT NOT NULL,
status_ID INT NOT NULL,
pickup_ID INT NOT NULL,
json LONGTEXT,
CHECK (total_price > 0),
FOREIGN KEY (user_ID) REFERENCES account(ID),
FOREIGN KEY (break_ID) REFERENCES break(ID),
FOREIGN KEY (status_ID) REFERENCES status(ID),
FOREIGN KEY (pickup_ID) REFERENCES pickup_point(ID)
);

CREATE TABLE catalog(
ID INT AUTO_INCREMENT PRIMARY KEY,
catalog_name NVARCHAR(30) NOT NULL,
validity_start_date DATE NOT NULL,
validity_end_date DATE NOT NULL,
CHECK (validity_start_date < validity_end_date)
);

CREATE TABLE special_offer(
ID INT AUTO_INCREMENT PRIMARY KEY,
title NVARCHAR(16) NOT NULL,
description NVARCHAR(64),
offer_code NVARCHAR(8) NOT NULL,
validity_start_date DATE NOT NULL,
validity_end_date DATE NOT NULL,
CHECK (validity_start_date < validity_end_date)
);

CREATE TABLE tag(
tag_ID INT AUTO_INCREMENT PRIMARY KEY,
tag NVARCHAR(32) NOT NULL
);

CREATE TABLE class(
ID INT AUTO_INCREMENT PRIMARY KEY,
year_class INT NOT NULL,
section_class NVARCHAR(1) NOT NULL
);

-- tabelle di mezzo

CREATE TABLE order_product(
order_ID INT,
product_ID INT,
quantity INT,
CHECK (quantity > 0),
FOREIGN KEY (order_ID) REFERENCES user_order(ID),
FOREIGN KEY (product_ID) REFERENCES product(ID),
CONSTRAINT pk_order_product PRIMARY KEY (order_ID, product_ID)
);

CREATE TABLE cart_product(
cart_ID INT,
product_ID INT,
quantity INT,
CHECK (quantity > 0),
FOREIGN KEY (cart_ID) REFERENCES cart(ID),
FOREIGN KEY (product_ID) REFERENCES product(ID),
CONSTRAINT pk_cart_product PRIMARY KEY (cart_ID, product_ID)
);

CREATE TABLE ingredient_tag(
ingredient_ID INT,
tag_ID INT,
FOREIGN KEY (ingredient_ID) REFERENCES ingredient(ID),
FOREIGN KEY (tag_ID) REFERENCES tag(tag_ID),
CONSTRAINT pk_ingredient_tag PRIMARY KEY (ingredient_ID, tag_ID)
);

CREATE TABLE catalog_product(
catalog_ID INT,
product_ID INT,
FOREIGN KEY (catalog_ID) REFERENCES catalog(ID),
FOREIGN KEY (product_ID) REFERENCES product(ID),
CONSTRAINT pk_catalog_product PRIMARY KEY (catalog_ID, product_ID)
);

CREATE TABLE offer_category(
offer_ID INT,
category_ID INT,
FOREIGN KEY (offer_ID) REFERENCES special_offer(ID),
FOREIGN KEY (category_ID) REFERENCES category(ID),
CONSTRAINT pk_offer_category PRIMARY KEY (offer_ID, category_ID)
);

CREATE TABLE product_ingredient(
product_ID INT,
ingredient_ID INT,
ingredient_quantity nvarchar(32) NOT NULL,
product_making_notes nvarchar(128),
CHECK (ingredient_quantity > 0),
FOREIGN KEY (product_ID) REFERENCES product(ID),
FOREIGN KEY (ingredient_ID) REFERENCES ingredient(ID),
CONSTRAINT pk_product_ingredient PRIMARY KEY (product_ID, ingredient_ID)
);

CREATE TABLE account_class (
class_ID INT NOT NULL,
account_ID INT NOT NULL,
start_year DATE NOT NULL,
FOREIGN KEY (class_ID) REFERENCES class(ID),
FOREIGN KEY (account_ID) REFERENCES account(ID)
);