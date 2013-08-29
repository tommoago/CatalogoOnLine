$(document).ready(function()
{
    $("#formproduct").validate(
    {
        rules:
        {
            name: "required",
            descr: "required",
            w_price: "required",
            r_price: "required",
            s_price: "required",
            cod: "required",
            barcode: "required",
            s_qty: "required",
            p_qty: "required",
            c_qty: "required",
        },
        messages:
        {
            name: " name required ",
            descr: " description required ",
            w_price: "required",
            r_price: "required",
            p_price: "required",
            cod: " code required ",
            barcode: " barcode required ",
            s_qty: "required",
            p_qty: "required",
            c_qty: "required",
        }
    });
});