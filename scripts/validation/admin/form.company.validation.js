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
                            address: "required",
                            city: "required",
                            province: "required",
                            country: "required",
                            zip: "required",
                            email: {
                                required: true,
                                email: true
                            },
                            website: "required"

                        },
                messages:
                        {
                            name: "required ",
                            description: "required ",
                            piva: "required ",
                            telephone: "required ",
                            fax: "required ",
                            address: "required",
                            city: "required",
                            province: "required",
                            country: "required",
                            zip: "required",
                            email : " email not valid",
                            website: "required"
                        }
            });
});



