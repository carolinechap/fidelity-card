$(document).ready(function() {
    $(document).on("click", "#btn-add-customer-card", function(event) {
        event.preventDefault();
        var addCardForm = $("#add-card");
        var linkSubmit = addCardForm.attr('action');
        $.ajax({
            type: "POST",
            url: (linkSubmit),
            data: addCardForm.serialize(),
            success: function (response) {
                $('#customer-add-card').replaceWith(response);
                $('#message').removeClass('d-none');
            },
            error: function () {
                $('#message').removeClass('d-none');
            },
        });
    });

    var $customers = $('#lost_type_card_customers');
    // $(document).on("change", $customers, function() {
    //     // ... retrieve the corresponding form.
    //     var $form = $(this).closest('form');
    //     // Simulate form data, but only include the selected value.
    //     var data = {};
    //     data[$customers.attr('name')] = $customers.val();
    //     // Submit data via AJAX to the form's action path.
    //     console.log(data);
    //     $.ajax({
    //         url : $form.attr('action'),
    //         type: $form.attr('method'),
    //         data : data,
    //         success: function(html) {
    //             // Replace current position field ...
    //             $('#lost_type_card_cards').replaceWith(
    //                 // ... with the returned one from the AJAX response.
    //                 $(html).find('#lost_type_card_cards')
    //             );
    //             // Position field now displays the appropriate positions.
    //         }
    //     });
    // });
});