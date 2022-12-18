USE sandwiches;

-- user
INSERT INTO `user`(name, surname, email, password)
VALUES
('Alessio', 'Modonesi', 'alessio.modonesi@iisviolamarchesini.edu.it', '1234'),
('Mattia', 'Gallinaro', 'mattia.gallinaro@iisviolamarchesini.edu.it', '5678'),
('Mattia', 'Zanini', 'mattia.zanini@iisviolamarchesini.edu.it', '4321'),
('Christian', 'Mondini', 'christian.mondini@iisviolamarchesini.edu.it', '8765');

INSERT INTO reset(`user`, password, expires, completed)
VALUES
(1, 'PaSSworD', Now(), TRUE),
(2, 'CHanGE',  Now() , FALSE);

INSERT INTO class(year, section)
VALUES
(5, 'F'),
(5, 'E');

INSERT INTO user_class(`user`, class, `year`)
VALUES
(1, 1, '2022'),
(3, 1, '2022'),
(2, 2, '2022'),
(4, 2, '2022');

-- product
INSERT INTO nutritional_value(kcal, fats, carbohydrates, proteins)
VALUES
(200, 10, 50, 15),
(300, 15, 60, 15),
(250, 10, 40, 5),
(150, 5, 30, 5),
(50, 0, 15, 0);

INSERT INTO product(name, price, description, quantity, nutritional_value)
VALUES
('panino con prosciutto', 2, 'panino con prosciutto cotto coop', 20, 1),
('panino con salame', 2, 'panino con salame ungherese', 20, 1),
('panino con bresaola', 2, 'panino con bresaola despar', 20, 1),
('panino con formaggio', 2, 'panino con formaggio conad', 20, 1),
('piadina con cotto', 3, 'piadina con prosciutto cotto coop', 20, 2),
('piadina con bresaola', 3, 'piadina con bresaola despar', 20, 2),
('piadina con salame', 3, 'piadina con salame ungherese', 20, 2),
('brioche con crema', 2, 'brioche con crema pasticcera', 20, 3),
('briosche con cioccolato', 2, 'brioche con crema al cioccolato', 20, 3),
('croccantelle', 2, 'piadina con salame ungherese', 20, 4),
('patatine', 2, 'piadina con salame ungherese', 20, 4),
('coca cola', 2, 'bibita gassata', 20, 5),
('the al limone', 2, 'bibita dolce', 20, 5),
('red bull', 2, 'bibita energetica', 20, 5);

INSERT INTO favourite(`user`, product)
VALUES
(1, 1),
(2, 5),
(3, 8),
(4, 11);

INSERT INTO ingredient(name, quantity, description)
VALUES
('pane', 50, 'pane toscano'),
('piadina', 50, 'piadina romagnola'),
('brioche', 50, 'brioche artigianale'),
('salame', 80, 'salame ungherese'),
('prosciutto', 80, 'cotto coop'),
('bresaola', 80, 'bresaola despar'),
('formaggio', 80, 'formaggio conad'),
('crema', 60, 'crema pasticcera'),
('cioccolato', 60, 'crema al cioccolato');

INSERT INTO product_ingredient(product, ingredient)
VALUES
(1, 1),
(1, 4),
(2, 1),
(2, 3),
(3, 1),
(3, 5),
(4, 1),
(4, 5),
(5, 2),
(5, 4),
(6, 2),
(6, 5),
(7, 2),
(7, 3),
(10, 3),
(10, 8),
(11, 3),
(11, 9);

INSERT INTO tag(name)
VALUES
('panino'),
('piadina'),
('brioche'),
('snack'),
('bibita');

INSERT INTO product_tag(product, tag)
VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 2),
(6, 2),
(7, 2),
(8, 3),
(9, 3),
(10, 4),
(11, 4),
(12, 5),
(13, 5),
(14, 5);

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

INSERT INTO product_allergen(product, allergen)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO offer(price, expiry, description)
VALUES
('1', '2022/01/21', 'offerta panini'),
('2', '2021/03/01', 'offerta piadine');

INSERT INTO product_offer(product, offer)
VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 2),
(6, 2),
(7, 2);

-- order
INSERT INTO `status`(description)
VALUES
('ordinato'),
('pronto'),
('annullato');

INSERT INTO break(`time`)
VALUES
('09:25'),
('10:25'),
('11:25');

INSERT INTO pickup(name)
VALUES
('Settore A Itis'),
('Settore B Itis'),
('Ipsia'),
('Agrario');

INSERT INTO pickup_break(pickup, break)
VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 3);

INSERT INTO `order`(`user`, pickup, break, `status`)
VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 2, 3, 2),
(4, 2, 3, 3);

INSERT INTO product_order(product, `order`)
VALUES
(1, 1),
(1, 1),
(2, 2),
(2, 2),
(3, 3),
(3, 4);

INSERT INTO `cart`(`user`, product, quantity)
VALUES
('1', '2', '4'),
('2', '1', '3'),
('3', '3', '2');