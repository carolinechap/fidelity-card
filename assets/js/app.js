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

    // Init ranking process
    getRankings();

    // Called on pagination change
    $('.pagination').on("click", ".page-link", function() {

        $('#results').empty();
        const page = $(this).attr('data-page');
        getRankings(page);

    });

    // Start ajax call
    function getRankings(page = 1) {
        $.ajax({
            url : '/api/cards.jsonld?order%5BpersonalScore%5D=desc&pagination=true&page=' + page, // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP

            success : function(result) {

                const totalItems = result["hydra:totalItems"];
                const itemsPerPage = 5;
                const nbPages = (totalItems / itemsPerPage).toFixed(0);
                $('.pagination').empty();

                for (let i = 1; i <= nbPages; i++) {

                    $(`<li class="page-item"><a class="page-link" data-page="${i}" href="javascript:void(0)">${i}</a></li>`).appendTo($('ul.pagination'));

                }


                $.each(result["hydra:member"], function (i, card) {
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
    }
    
});