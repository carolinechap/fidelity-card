$(document).ready(function() {
    $(document).on("click", "#btn-add-customer-card", function(event) {
        event.preventDefault();
        var addCardForm = $("#form-add-card");
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

    var $customers = $('select#lost_type_card_customers');
    var $form = $customers.closest('form');
    $($customers).change(function () {
        event.preventDefault();
        var data = {};
        data[$customers.attr('name')] = $customers.val();
        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data : data,
            success: function(html) {
                $('#lost_type_card_cards').replaceWith(
                    $(html).find('#lost_type_card_cards')
                );
                $('#btn-select-customer').replaceWith(
                    $(html).find('#btn-select-customer')
                );
            },
            error: function(error) {
                $('#error-ajax').removeClass('d-none');
            },
            complete: function(response) {
                $($customers).attr('disabled', 'disabled');
            }
        });
    });
});