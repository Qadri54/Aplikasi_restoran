import "flowbite";
import "./bootstrap";

$('.button_order').click(function () {
    const data = $(this).data('id');
    $('#modal_name').val(data);
})

