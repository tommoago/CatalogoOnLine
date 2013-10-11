$(document).ready(function()
{
    $("#forminvoice").validate(
            {
                rules:
                        {
                            inv_number: {
                                digits: true,
                                required: true
                            }
                        },
                messages:
                        {
                            inv_number: " required "
                        }
            });
});