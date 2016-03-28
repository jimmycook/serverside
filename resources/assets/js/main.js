window.$ = window.jQuery = require('jquery');
var moment = require('moment');
import Vue from 'vue';
var bootstrap = require('bootstrap');


// Account Page jQuery
$(".listing-utility").on('click', function() {
    var url = '/api/listings/' + $(this).data('listing');
    var listingStatus = $(this).data('status');

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
    if (button.data('status')  == 'processing') {
        $.post('/api/complete'), {id: button.data('order')}, function(data) {
            console.log('fired');
            if(data)
                location.reload();
            else {
                alert('This action could not be completed');
            }
        }
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
