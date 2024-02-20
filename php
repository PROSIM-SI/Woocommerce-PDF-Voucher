<?php
function add_custom_surcharge_to_product( $cart_object ) {
    $special_product_id = 4815;
    $additional_fee = 2.80;
    $found_special_product = false;
    $found_other_products = false;

    // Kontrola obsahu košíka
    foreach ( $cart_object->cart_contents as $item ) {
        if ( $item['product_id'] == $special_product_id ) {
            $found_special_product = true;
        } else {
            $found_other_products = true;
        }
    }

    // Skryť poplatok, ak je spôsob doručenia "Emailom" alebo existuje iný produkt
    if ( (isset($_COOKIE['hide_extra_fee']) && $_COOKIE['hide_extra_fee'] === 'true') || $found_other_products ) {
        return; // Nepridáva poplatok
    }

    // Pridať poplatok, ak je v košíku len špeciálny produkt
    if ( $found_special_product && !$found_other_products ) {
        $cart_object->add_fee( 'Extra poplatok', $additional_fee );
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'add_custom_surcharge_to_product' );
?>
