USE sandwiches;

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