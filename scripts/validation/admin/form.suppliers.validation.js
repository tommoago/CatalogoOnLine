$(document).ready(function()
{
    $("#formsuppliers").validate(
            {
                rules:
                        {
                            name: "required",
                            description: "required",
                            piva: "required",
                            email: {
                                required: true,
                                email: true
                            },
                            telephone: "required",
                            fax: "required",
                            address: "required"

                        },
                messages:
                        {
                            name: "required ",
                            description: "required ",
                            piva: "required ",
                            email: " email not valid",
                            telephone: "required ",
                            fax: "required ",
                            address: "required"
                        }
            });
});



