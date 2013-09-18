$(document).ready(function()
{
    $("#formcategories").validate(
    {
        rules:
        {
            name: "required",
        },
        messages:
        {
            name: " required ",
        }
    });
});