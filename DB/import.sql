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
('panino col formaggio', 1.20, 'panino con il formaggio del despar', 15, 2),
('piadina al cotto', 3.50, 'piadina con il prosciutto cotto e il formaggio', 7, 3);

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

INSERT INTO `cart`(`user`, product, quantity)
VALUES
('1', '2', '4'),
('2', '1', '3'),
('3', '3', '2');

INSERT INTO offer(price, expiry, description)
VALUES
('10', '2022/01/21', 'offerta n. 1'),
('20', '2021/03/01', 'offerta n. 2');

INSERT INTO allergen(name)
VALUES
('Latte e derivati'),
('Uova e derivati'),
('Frutta con guscio'),
('Glutine'),
('Cereali'),
('Soia'),
('Arachidi e derivati'),
('Sesamo e derivati');

INSERT INTO `order`(`user`, pickup, break, `status`)
VALUES
(1, 1, 1, 2),
(2, 2, 1, 3),
(3, 1, 2, 1),
(1, 2, 1, 3);

INSERT INTO product_order(product, `order`)
VALUES
(1, 2),
(1, 3),
(2, 3),
(2, 4),
(3, 4),
(3, 2);

INSERT INTO user_class(`user`, class, `year`)
VALUES
(1,1, '2022'),
(2,3, '2021'),
(3,2, '2022'),
(1,3, '2021');

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


INSERT INTO reset(`user`, password, expires, completed)
VALUES
(1, 'EHV0L3V1', Now(), TRUE),
(2, '',  Now() , FALSE),
(4, 'C4P0BRANC0D31P4GUR1', Now(), TRUE);


INSERT INTO favourite(`user`, product)
VALUES
(1, 6),
(2, 3),
(3, 2),
(4, 4);


INSERT INTO product_allergen(product, allergen)
VALUES
(2, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(5, 1);


INSERT INTO pickup_break(pickup, break)
VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);


INSERT INTO product_tag(product, tag)
VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 1),
(6, 3);


INSERT INTO product_offer(product, offer)
VALUES
(1, 1),
(2, 1),
(4, 1),
(6, 2);