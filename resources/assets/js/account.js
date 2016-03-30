// Account Page jQuery

$(document).ready(function() {
    // var hiddenImageField = $("#image-type");
    // hiddenImageField.val("image-file");
})

// Globals
var pressed;
var listing;

$(".listing-utility").on('click', function() {
    pressed = $(this);
    var url = '/api/listings/' + pressed.data('listing');
    var listingStatus = pressed.data('status');

    $.get(url, function(data) {
        data = $.parseJSON(data);
        listing = data;
        var header =  $("#listing-modal-header");
        var body = $("#listing-modal-body");
        var button = $("#listing-modal-button");
        var cancelButton = $("#listing-order-cancel-button");

        // Make sure the cancel button is hidden
        cancelButton.hide();

        button.data({
            listing: data.slug,
            order: data.order.id,
            status: listingStatus
        });

        if (listingStatus == 'completed' || listingStatus == 'processing') {
            var address = data.order.address;

            header.html("Order Information");

            var content = "<p><strong>Name:</strong> " + data.user.first_name + " " + data.user.last_name + "</p>";
            content += "<p><strong>Email:</strong> " + data.user.email + "</p>";
            content += "<p><strong>Address:</strong> " + data.order.address + "</p>";
            content += "<p><strong>Current Status:</strong> " + data.order.status + "</p>";
            body.html(content);

            if (listingStatus == 'completed') {
                button.hide();
            }
            else if (listingStatus == 'processing') {
                button.removeClass();
                button.addClass("btn btn-primary");
                button.html("Mark order as completed");

                // Show the correct buttons
                cancelButton.show();
                button.show();
            }
        }
        else
        {
            header.html('Are you sure?');
            body.html("You are about to delete this listing, this action is not reverseable.");
            button.removeClass();
            button.addClass("btn btn-danger");
            button.show();
            button.html("Delete");
        }
        $("#listing-modal").modal('show');
    });

});

// Cancel order button, only shows when the order status is processing
$("#listing-order-cancel-button").click(function() {
    $.ajax({
        url: '/api/order/cancel',
        method: 'POST',
        data: {
            id: listing.order.id
        },
        success: function(data) {
            location.reload();
        }
    });
});

$("#create-listing-modal-button").click(function() {
    // $("#image-file-container").show();
    // $("#image-url-container").hide();
    $("#create-listing-modal").modal('show');
});

// Was for image url uploaded that has been removed
// $("#image-switch").click(function() {
//     var clickedButton = $(this);
//     var hiddenImageField = $("#image-type");
//     if (clickedButton.data('image') == 'image-file')
//     {
//         clickedButton.html('Use an image upload instead');
//         clickedButton.data('image', 'image-url');
//         hiddenImageField.val("image-url");
//         $("#image-file-container").hide();
//         $("#image-url-container").show();
//     }
//     else if (clickedButton.data('image') == 'image-url')
//     {
//         clickedButton.data('image', 'image-file');
//         clickedButton.html('Use a URL instead');
//         hiddenImageField.val("image-file");
//         $("#image-file-container").show();
//         $("#image-url-container").hide();
//     }
// });

// Main modal button
$("#listing-modal-button").click(function() {
    var button = $("#listing-modal-button");
    var orderID = {id: button.data('order')};
    if (button.data('status')  == 'processing') {
        $.ajax({
            url: '/api/order/complete',
            method: 'POST',
            data: orderID,
            success: function() {
                pressed.data("status", "completed");
                pressed.removeClass("btn-primary");
                pressed.addClass("btn-success");
                $("#listing-modal").modal('hide');
            }
        })
    }
    else if (button.data('status') == 'none') {
        $.post('/api/listing/delete', {slug: button.data('listing')}, function(data) {
            if(data)
                location.reload();
            else
                alert('This action could not be completed');
        });
    }
});
