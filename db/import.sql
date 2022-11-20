insert into category(name, iva_tax)
values
('panino', 0.22),
('bevanda', 0.18),
('piadina', 0.22);

insert into nutritional_value(kcal, fats, carbohydrates, proteins)
values
(235, 25, 80, 7),
(348, 30, 63, 6),
(249, 17, 65, 25),
(80, 0, 10, 1);

insert into product(name, price, description, quantity, category_ID, nutritional_value_ID)
values
('panino al prosciutto', 3, 'panino fatto col miglior prosciutto in cirolazione', 26, 1, 1),
('panino al salame', 3, 'panino fatto col salame de me nonno', 17, 1, 2),
('panino proteico', 3, 'panino che possono mangiare solo i veri jimbro', 15, 1, 3),
('coca cola', 1, 'bevanda frizzante', 24, 2, 4);

insert into ingredient(name, available_quantity, description)
values
('salame', 60, 'salame de me nonno'),
('prosciutto', 35, 'miglior prosciutto in cirolazione'),
('pane', 80, 'pane da panino'),
('bresaola', 40, 'we jim');

insert into product_ingredient(product_ID, ingredient_ID, ingredient_quantity, product_making_notes)
values
(1, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(2, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(3, 3, 2, 'se è un panino è ovvio che ci sia del pane :D'),
(1, 2, 3, 'per panino al prosciutto'),
(2, 1, 3, 'per panino al salame'),
(3, 4, 4, 'per panino dei jimbro');