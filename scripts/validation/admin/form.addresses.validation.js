$(document).ready(function()
{
    $("#formaddresses").validate(
            {
                rules:
                        {
                            street: "required",
                            city: "required",
                            prov: "required",
                            zip: {
                                digits: true,
                                required: true
                            },
                            country: "required"

                        },
                messages:
                        {
                            street: "required ",
                            city: "required ",
                            prov: "required ",
                            zip: "required ",
                            country: "required "
                        }
            });
});



