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

    var $customers = $('select#lost_type_card_customers');
    var $cards = $('select#lost_type_card_cards');
    var $form = $customers.closest('form');
    $($customers).change(function () {
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
                $('#message').removeClass('d-none');
            }
        });
    });
    $($form).submit(function (event) {
        event.preventDefault();
        var data = {};
        data[$customers.attr('name')] = $customers.val();
        data[$cards.attr('name')] = $cards.val();
        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data : $form.serialize(),
            success: function(html) {
                var message = $('#message');
                message.replaceWith(
                    $(html).find('#message')
                );
                message.removeClass('d-none');
            },
            error: function(error) {
                $('#message').removeClass('d-none');
            }
        });
    });
});