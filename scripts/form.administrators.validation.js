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
            name: " name required ",
            user: " username required ",
            password: " password required",
        }
    });
});