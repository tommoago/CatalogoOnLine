$(document).ready(function()
{
    $("#formcompany").validate(
        {
        rules:
        {
            name: "required",
            description: "required",
            piva: "required",
            telephone: "required",
            fax: "required",
            address: "required"

        },
        messages:
        {
            name: "required ",
            description: "required ",
            piva: "required ",
            telephone: "required ",
            fax: "required ",
            address: "required"
        }
        });
});



