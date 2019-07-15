/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
import 'bootstrap';
//import '../js/api.js';

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(function() {
    $.ajax({
        paging: true,
        pageLength: 5,
        url : '/api/cards.json?order%5BpersonalScore%5D=desc&pagination=true', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP

        success : function(result) {
            $.each(result, function (i, card) {
                //console.log(result);
                let classementDatas =
                    '<tr><td scope="row">' + card.user.firstname + ' ' + card.user.lastname +  '</td> ' +
                    '<td scope="row" class="text-center">' + card.personalScore + '</td>' +
                    '<td scope="row" class="text-center">' + card.countVictory  + '/' + card.countGames + '</td>' +
                    '<td scope="row" class="text-center">' + card.store.name + '</td></tr>';
                $("#results").append(classementDatas);
                //console.log(classementDatas);
            })
        },
        error : function(result) {
            let error =
                '<th scope="row"> Oups... une erreur</th>';
            $('#results').append(error);
            console.log('erreur réseau');
        }
    });
    $('#demo').pagination({
        dataSource: '/api/cards.json?order%5BpersonalScore%5D=desc&pagination=true',
        locator: 'items',
        totalNumber: 120,
        pageSize: 20,
        ajax: {
            beforeSend: function() {
                dataContainer.html('Loading data from flickr.com ...');
            }
        },
        callback: function(data, pagination) {
            // template method of yourself
            var html = template(data);
            dataContainer.html(html);
        }
    })
});