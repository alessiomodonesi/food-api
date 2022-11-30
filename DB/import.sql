USE sandwiches;

INSERT INTO break(`time`)
VALUES
('09:25'),
('11:25');

INSERT INTO class(year, section)
VALUES
(5, 'F'),
(5,'E'),
(4, 'E');

INSERT INTO ingredient(name, quantity, description)
VALUES
('salame', 60, 'salame de me nonno'),
('prosciutto', 35, 'miglior prosciutto in cirolazione'),
('pane', 80, 'pane da panino'),
('bresaola', 40, 'we jim'),
('formaggio', 60, 'formaggio del despar');

INSERT INTO pickup(name)
VALUES
('Settore A itis'),
('Settore B itis');

INSERT INTO nutritional_value(kcal, fats, carbohydrates, proteins)
VALUES
(235, 25, 80, 7),
(348, 30, 63, 6),
(249, 17, 65, 25),
(80, 0, 10, 1);

INSERT INTO product(name, price, description, quantity, nutritional_value)
VALUES
('panino al prosciutto', 3, 'panino fatto col miglior prosciutto in cirolazione', 26, 1),
('panino al salame', 3, 'panino fatto col salame de me nonno', 17, 2),
('panino proteico', 3, 'panino che possono mangiare solo i veri jimbro', 15, 3),
('coca cola', 1, 'bevanda frizzante', 24, 4),
('panino col formaggio', 1.20, 'panino con il formaggio del despar', 15, 2);

INSERT INTO `status`(description)
VALUES
('ordinato'),
('pronto'),
('annullato');

INSERT INTO tag(name)
VALUES
('panino'),
('bevanda'),
('piadina');

INSERT INTO `user`(name, surname, email, password)
VALUES
('Mattia', 'Gallo', 'mattia.gallinaro@iisviolamarchesini.edu.it', 'CA71@F'),
('Mattia', 'Zanini', 'mattia.zanini@iisviolamarchesini.edu.it', 'SIUUUUU'),
('Alessio', 'Modonesi', 'alessio.modonesi@iisviolamarchesini.edu.it', 'CACCIOTTI'),
('Cristian', 'Mondini', 'cristian.mondini@iisviolamarchesini.edu.it', 'FORZAROMA');

INSERT INTO `cart`(`user`) 
VALUES 
('1');

INSERT INTO offer(price, expiry, description)
VALUES
('10', '2022/01/21', 'offerta n. 1'),
('20', '2021/03/01', 'offerta n. 2');

INSERT INTO product_order(product, `order`)
VALUES
(1, 2),
(1, 5),
(2, 5),
(2, 4),
(3, 4),
(3, 2);

INSERT INTO cart_product(cart, product, quantity)
VALUES
(1, 4, 1),
(1, 1, 2);

INSERT INTO user_class(`user`, class, `year`)
VALUES
(1,1, '2022'),
(2,3, '2021'),
(3,2, '2022'),
(1,4, '2021');

INSERT INTO product_ingredient(product, ingredient)
VALUES
(1, 3),
(2, 3),
(3, 3),
(5, 3),
(1, 2),
(2, 1),
(3, 4),
(5, 5);

-- import mancanti

 CREATE  TABLE sandwiches.`order` ( 
	id                   INT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	`user`               INT UNSIGNED NOT NULL,
	created              TIMESTAMP  NOT NULL DEFAULT (CURRENT_TIMESTAMP),
	pickup               INT UNSIGNED NOT NULL,
	break                INT UNSIGNED NOT NULL,
	`status`             INT UNSIGNED NOT NULL,
	json                 LONGTEXT
 );

CREATE  TABLE sandwiches.reset ( 
	id                   INT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	`user`               INT UNSIGNED NOT NULL,
	password             VARCHAR(128)  NOT NULL,
	requested            TIMESTAMP  NOT NULL DEFAULT (CURRENT_TIMESTAMP),
	expires              TIMESTAMP  NOT NULL,
	completed            BOOLEAN  NOT NULL DEFAULT (FALSE)    
 );

 CREATE  TABLE sandwiches.favourite ( 
	`user`           INT UNSIGNED NOT NULL,
	product          INT UNSIGNED NOT NULL,
	created          TIMESTAMP   DEFAULT (CURRENT_TIMESTAMP)    
 );

 CREATE  TABLE sandwiches.allergen ( 
	id                   INT UNSIGNED NOT NULL   AUTO_INCREMENT  PRIMARY KEY,
	name                 VARCHAR(64)  NOT NULL     
 );

 CREATE  TABLE sandwiches.ingredient_allergen ( 
	ingredient       INT UNSIGNED NOT NULL,
	allergen         INT UNSIGNED NOT NULL
 );

 CREATE  TABLE sandwiches.pickup_break ( 
	pickup           INT UNSIGNED NOT NULL,
	break            INT UNSIGNED NOT NULL     
 );

 CREATE  TABLE sandwiches.product_tag ( 
	product          INT UNSIGNED NOT NULL,
	tag              INT UNSIGNED NOT NULL    
 );

  CREATE  TABLE sandwiches.product_offer ( 
	product          INT UNSIGNED NOT NULL,
	offer            INT UNSIGNED NOT NULL  
 );