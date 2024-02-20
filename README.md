Ak používate tento plugin na genovarie poukážok tak tu mám pre vás jeden celkom užitočný kódik.

Tento plugin povoľuje zaslanie v elektronickej ale aj tlačenej verzii.
Nemysleli však na to, že v košíku môže byť aj iný produk ktorý nie je virtuálny a teda je potrebné aplikovať pravidlo poplatku za dopravu.

Čo tento kód zastrešuje?

JavaScript: Skrytie Extra Poplatku

    Kontroluje, či je spôsob doručenia nastavený na "Emailom".
    Ak áno, skryje extra poplatok nastavením cookie.


PHP: Logika pre WooCommerce

    Dynamicky pridáva alebo skrýva extra poplatok na základe cookie.
    Skrýva poplatok, ak existuje akýkoľvek iný produkt v košíku/pokla


    *** PHP FUNKCIA ***
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

*** JavaSrcipt FUNKCIA ***

<script>
jQuery(document).ready(function($) {
    var deliveryByEmail = $('.variation-Spsobdoruenia:contains("Emailom")').length > 0;
    var deliveryByCourier = $('.variation-Spsobdoruenia:contains("Kuriérom")').length > 0;

    if (deliveryByEmail && !deliveryByCourier) {
        document.cookie = "hide_extra_fee=true; path=/";
    } else {
        document.cookie = "hide_extra_fee=false; path=/";
    }
});
</script>
