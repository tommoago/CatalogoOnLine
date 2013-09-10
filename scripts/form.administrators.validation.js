$(document).ready(function()
{
    $("#formadministrators").validate(
    {
        rules:
        {
            name: "required",
            user: "required",
            password: "required",
        },
        messages:
        {
            name: " required ",
            user: " required ",
            password: " required",
        }
    });
});