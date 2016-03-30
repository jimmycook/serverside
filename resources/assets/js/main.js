window.$ = window.jQuery = require('jquery');
var moment = require('moment');
import Vue from 'vue';
var bootstrap = require('bootstrap');

var pressed;

// Account Page jQuery
$(".listing-utility").on('click', function() {
    pressed = $(this);
    var url = '/api/listings/' + pressed.data('listing');
    var listingStatus = pressed.data('status');

    $.get(url, function(data) {
        data = $.parseJSON(data)

        var header =  $("#listing-modal-header");
        var body = $("#listing-modal-body");
        var button = $("#listing-modal-button");

        button.data({
            listing: data.slug,
            order: data.order.id,
            status: listingStatus
        });

        if (listingStatus == 'completed' || listingStatus == 'processing') {
            var address = data.order.address;

            header.html("Order Information");
            body.html(data.name);

            if (listingStatus == 'completed') {
                button.hide();
            }
            else if (listingStatus == 'processing') {
                button.removeClass();
                button.addClass("btn btn-primary");
                button.show();
                button.html("Mark Order As Completed");
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

$("#listing-modal-button").click(function() {
    var button = $("#listing-modal-button");
    var orderID = {id: button.data('order')};
    if (button.data('status')  == 'processing') {
        $.ajax({
            url: '/api/complete',
            method: 'POST',
            data: orderID,
            success: function() {
                console.log('should update button here');
                pressed.data("status", "completed");
                pressed.removeClass("btn-primary");
                pressed.addClass("btn-success");
                $("#listing-modal").modal('hide');
            }
        })
    }
    else if (button.data('status') == 'none') {
        $.post('/api/delete', {slug: button.data('listing')}, function(data) {
            if(data)
                location.reload();
            else
                alert('This action could not be completed');
        });
    }
});
