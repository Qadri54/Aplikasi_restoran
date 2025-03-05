import "flowbite";
import "./bootstrap";

$(".button_order").click(function () {
    const data = $(this).data("id");
    const idProduct = $(this).data("id_produk");
    $("#modal_name").val(data);
    $("#id_product").val(idProduct);
});
