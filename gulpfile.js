var elixir = require('laravel-elixir');

// Pull in the vueify plugin for elixirs
require('laravel-elixir-vueify');

elixir(function(mix) {
    mix.less('app.less');
    mix.browserify('main.js');
});
