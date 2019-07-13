$(function() {
    $.ajax({
        url : '/api/cards.json?order%5BpersonalScore%5D=dsc', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP

        success : function(result) {
            $.each(result, function (i, card) {
                console.log(result);
                // $concerts.append('<td>date: '+ event.venue.name +' </td>')
                let classementDatas =
                    '<th scope="row">' + card.user.firstname + ' ' + card.user.lastname +  '</th>' +
                    '<th scope="row">' + card.personalScore + '</th>' +
                    '<th scope="row">' + card.countVictory  + '/' + card.countGames + '</th>' +
                    '<th scope="row">' + card.store.name + '</th>';
                $('#classement').append(classementDatas);
            })
        },
        error : function(result) {
            let error =
                '<th scope="row"> Oups... une erreur</th>';
            $('#classement').append(error);
            console.log('erreur réseau');
        }
    });
});