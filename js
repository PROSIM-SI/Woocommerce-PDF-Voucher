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
