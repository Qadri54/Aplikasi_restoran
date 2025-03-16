import "flowbite";
import "./bootstrap";

$(".button_order").click(function () {
    const data = $(this).data("nama_produk");
    const idProduct = $(this).data("id_produk");
    $("#modal_name").val(data);
    $("#id_product").val(idProduct);
});
