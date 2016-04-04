window.$ = window.jQuery = require('jquery');
var moment = require('moment');
import Vue from 'vue';
var bootstrap = require('bootstrap');

// Image error handling
$('img').on("error", function() {
    $(this).attr('src', '/images/placeholder.png');
});

// Set up tooltips
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

require('./account.js');
