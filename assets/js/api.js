$(function () {

    // Init ranking process
    getRankings();

    // Called on pagination change
    $('.pagination').on("click", ".page-link", function () {

        $('#results').empty();
        const page = $(this).attr('data-page');
        getRankings(page);


    });

    // Start ajax call
    function getRankings(page = 1) {

        $.ajax({
            url: '/api/cards.jsonld?order%5BpersonalScore%5D=desc&personalScore%5Bgt%5D=0&pagination=true&page=' + page, // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP

            success: function (result) {

                const totalItems = result["hydra:totalItems"];
                const itemsPerPage = 5;
                const nbPages = (totalItems / itemsPerPage).toFixed(0);
                $('.pagination').empty();

                if ((page - 1) && page <= nbPages) {
                    $(`<li class="page-item"><a class="page-link" data-page="${parseInt(page) - 1}" href="javascript:void(0)">Previous</a></li>`).appendTo($('ul.pagination'));
                }

                for (let i = 1; i <= nbPages; i++) {

                    $(`<li class="page-item"><a class="page-link" data-page="${i}" href="javascript:void(0)">${i}</a></li>`).appendTo($('ul.pagination'));

                }
                page = parseInt(page);

                if ((page + 1) && page < nbPages) {
                    $(`<li class="page-item"><a class="page-link" data-page="${parseInt(page) + 1}" href="javascript:void(0)">Next</a></li>`).appendTo($('ul.pagination'));
                }


                $.each(result["hydra:member"], function (i, card) {
                    console.log(card);

                    if (typeof (card.user) !== 'undefined') {
                        let classementDatas =
                            '<tr><td scope="row">' + card.user.firstname + ' ' + card.user.lastname + '</td> ' +
                            '<td scope="row" class="text-center">' + card.personalScore + '</td>' +
                            '<td scope="row" class="text-center">' + card.countVictory + '/' + card.countGames + '</td>' +
                            '<td scope="row" class="text-center">' + card.store.name + '</td></tr>';
                        $("#results").append(classementDatas);
                    }

                })
            },
            error: function (result) {
                let error =
                    '<tr><td colspan="4" class="text-center"> Le tableau est vide</td></tr>';
                $('#results').append(error);
                console.log('erreur réseau');
            }
        });
    }

});