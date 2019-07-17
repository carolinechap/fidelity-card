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
});