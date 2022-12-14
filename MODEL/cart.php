<?php
class Cart{

    function getCartItems($user){//ritorna il carrello dell'utente con i relativi prodotti
        $sql = "select p.id, c.quantity, p.name, p.price, p.description from cart c ";
        $sql .= "inner join `user` u on u.id = c.`user` ";
        $sql .= "inner join product p on p.id = c.product ";
        $sql .= "where u.id = " .$user;
        return $sql;
    }
        
    // function getCartItems($user_ID){
    //     $sql = "select p.ID, cp.quantity, p.name, p.price, p.description from cart c ";
    //     $sql .= "inner join account a on a.ID = c.user_ID ";
    //     $sql .= "inner join cart_product cp on cp.cart_ID = c.ID "; 
    //     $sql .= "inner join product p on p.ID = cp.product_ID ";
    //     $sql .= "where a.ID = " .$user_ID;
    //     return $sql;
    // }

    function addItem($prod, $user){//aggiunge un prodotto al carrello dell'utente
        $sql = "
            insert into cart(user, product, quantity)
            values(" . $user . ", " . $prod .", 1);";

        //echo $sql . "</br>";
        return $sql;
    }

    function deleteItem($prod, $user){//rimuove un prodotto dal carello dell'utente
        $sql = "delete from cart
            where product = " . $prod ." and `user` = " . $user . ";";

        //echo $sql . "</br>";
        return $sql;
    }

    function setCartItemsAdd($prod, $user){//aumenta la quantitá di 1 del prodotto selezionato nel carrello dell'utente
        $sql = "update cart
                set quantity = quantity + 1
                where product = " . $prod ." and user = " . $user . ";";

        //echo $sql . "</br>";
        return $sql;
    }

    function setCartItemsRemove($prod, $user){//diminuisce di 1 la quantitá del prodotto nel carrello dell'utente
        $sql = "update cart
            set quantity = quantity - 1
            where product = " . $prod ." and user = " . $user . ";";
        
        //echo $sql . "</br>";
        return $sql;
    }
}
?>