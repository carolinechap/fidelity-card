$(document).ready(function() {
    $('#btn-add-customer-card').click(function(event) {
        event.preventDefault();
        var addCardForm = $("#add-card");
        var linkSubmit = addCardForm.attr('action');
        $.ajax({
            type: "POST",
            url: (linkSubmit),
            data: addCardForm.serialize(),
            success: function (response) {
                $('.container').replaceWith(response);
            },
            error: function () {
                var messageContainer = $('#message');
                messageContainer.removeClass('d-none');
            },
        });
    });
});