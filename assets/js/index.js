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

    var $customers = $('#lost_card_customers');
    $customers.change(function(event) {
        var $form = $customers.closest('form');
        event.preventDefault();
        var data = {};
        data[$customers.attr('name')] = $customers.val();
        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data : data,
            success: function(html) {
                $('#response').replaceWith(
                    $(html).find('#response')
                );
                $('#message').removeClass('d-none');
            },
            error: function(error) {
                $('#error-ajax').removeClass('d-none');
            },
            complete: function(response) {
                $('#lost_card_customers').attr('disabled', 'disabled');
            }
        });
    });
});