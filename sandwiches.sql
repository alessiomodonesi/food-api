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
active BIT DEFAULT 1,
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
extra_ready BIT DEFAULT 0,
active BIT DEFAULT 1,
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

-- import

INSERT INTO category(name, iva_tax)
VALUES
('panino', 0.22),
('bevanda', 0.18),
('piadina', 0.22);

INSERT INTO nutritional_value(kcal, fats, carbohydrates, proteins)
VALUES
(235, 25, 80, 7),
(348, 30, 63, 6),
(249, 17, 65, 25),
(80, 0, 10, 1);

INSERT INTO product(name, price, description, quantity, category_ID, nutritional_value_ID)
VALUES
('panino al prosciutto', 3, 'panino fatto col miglior prosciutto in cirolazione', 26, 1, 1),
('panino al salame', 3, 'panino fatto col salame de me nonno', 17, 1, 2),
('panino proteico', 3, 'panino che possono mangiare solo i veri jimbro', 15, 1, 3),
('coca cola', 1, 'bevanda frizzante', 24, 2, 4),
('panino col formaggio', 1.20, 'panino con il formaggio del despar', 15, 1, 2);

INSERT INTO ingredient(name, available_quantity, description)
VALUES
('salame', 60, 'salame de me nonno'),
('prosciutto', 35, 'miglior prosciutto in cirolazione'),
('pane', 80, 'pane da panino'),
('bresaola', 40, 'we jim'),
('formaggio', 60, 'formaggio del despar');

INSERT INTO product_ingredient(product_ID, ingredient_ID, ingredient_quantity, product_making_notes)
VALUES
(1, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(2, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(3, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(5, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(1, 2, 3, 'per panino al prosciutto'),
(2, 1, 3, 'per panino al salame'),
(3, 4, 4, 'per panino dei jimbro'),
(5, 5, 3, 'formaggio del panino');

INSERT INTO account(name, surname, email, password, active)
VALUES
('Mattia', 'Gallo', 'mattia.gallinaro@iisviolamarchesini.edu.it', 'CA71@F', 1),
('Mattia', 'Zanini', 'mattia.zanini@iisviolamarchesini.edu.it', 'SIUUUUU', 1),
('Alessio', 'Modonesi', 'alessio.modonesi@iisviolamarchesini.edu.it', 'CACCIOTTI', 1),
('Cristian', 'Mondini', 'cristian.mondini@iisviolamarchesini.edu.it', 'FORZAROMA', 1);

INSERT INTO class(year_class, section_class)
VALUES
(5, 'F'),
(5,'E'),
(4, 'E');

INSERT INTO account_class(class_ID, account_ID, start_year)
VALUES
(1,1, '2022/09/13'),
(2,3, '2021/09/15'),
(3,2, '2022/09/13'),
(1,4, '2021/09/15');

INSERT INTO break(break_time)
VALUES
('09:25'),
('11:25');

INSERT INTO `cart`(`user_ID`, `total_price`) 
VALUES 
('1','7.50');
-- ('2','0.00');

INSERT INTO status(description)
VALUES
('ordinato'),
('pronto'),
('annullato');

INSERT INTO pickup_point(description)
VALUES
('Settore A itis'),
('Settore B itis');

INSERT INTO tag(tag)
VALUES
('glutine'),
('latte e derivati'),
('nessuno'),
('uova o prodotti con uova');

INSERT INTO ingredient_tag(ingredient_ID, tag_ID)
VALUES
(1, 2),
(3, 4),
(3, 1),
(3,3);

INSERT INTO `ingredient_tag` (`ingredient_ID`, `tag_ID`)
VALUES 
('5', '2');

INSERT INTO `catalog`(catalog_name, validity_start_date, validity_end_date)
VALUES
('boh', '2022/11/23', '2022/11/30'),
('altro', '2021/03/02', '2022/12/14'),
('test', '2023/01/03', '2023/04/20');

INSERT INTO catalog_product(catalog_ID, product_ID)
VALUES
(1, 1),
(2, 2),
(3, 3),
(1, 4);

INSERT INTO special_offer(title, description, offer_code, validity_start_date, validity_end_date)
VALUES
('test1', 'esempio 1', 'AFKJ86FG', '2022/01/21', '2022/02/23'),
('test2', 'esempio 2', 'BGHE563F', '2021/03/01', '2021/10/04');

INSERT INTO cart_product(cart_ID, product_ID, quantity)
VALUES
(1, 4, 1),
(1, 1, 2);

INSERT INTO offer_category(offer_ID, category_ID)
VALUES
(1, 3),
(2, 1);

INSERT INTO user_order(user_ID, total_price, date_hour_sale, break_ID, status_ID, pickup_ID)
VALUES
(1, 7.20, '2022/11/22 09:30:00', 1, 2, 1),
(2, 3.20, '2022/11/22 11:10:00', 2, 3, 2),
(3, 4.00, '2022/01/02 08:57:00', 1, 2, 1);

INSERT INTO order_product(order_ID, product_ID, quantity)
VALUES
(1, 2, 2),
(1, 5, 1),
(2, 5, 1),
(2, 4, 2),
(3, 4, 1),
(3, 2, 1);