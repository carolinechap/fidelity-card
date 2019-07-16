(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./assets/css/app.css":
/*!****************************!*\
  !*** ./assets/css/app.css ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_concat__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.concat */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_number_to_fixed__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.number.to-fixed */ "./node_modules/core-js/modules/es.number.to-fixed.js");
/* harmony import */ var core_js_modules_es_number_to_fixed__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_to_fixed__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_parse_int__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.parse-int */ "./node_modules/core-js/modules/es.parse-int.js");
/* harmony import */ var core_js_modules_es_parse_int__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_parse_int__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_4__);





/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
__webpack_require__(/*! ../css/app.css */ "./assets/css/app.css"); // Need jQuery? Install it with "yarn add jquery", then uncomment to require it.


var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

 //import '../js/api.js';
//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(function () {
  // Init ranking process
  getRankings(); // Called on pagination change

  $('.pagination').on("click", ".page-link", function () {
    $('#results').empty();
    var page = $(this).attr('data-page');
    getRankings(page);
  }); // Start ajax call

  function getRankings() {
    var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
    $.ajax({
      url: '/api/cards.jsonld?order%5BpersonalScore%5D=desc&pagination=true&page=' + page,
      // La ressource ciblée
      type: 'GET',
      // Le type de la requête HTTP
      success: function success(result) {
        var totalItems = result["hydra:totalItems"];
        var itemsPerPage = 5;
        var nbPages = (totalItems / itemsPerPage).toFixed(0);
        $('.pagination').empty();

        if (page - 1 && page <= nbPages) {
          $("<li class=\"page-item\"><a class=\"page-link\" data-page=\"".concat(parseInt(page) - 1, "\" href=\"javascript:void(0)\">Previous</a></li>")).appendTo($('ul.pagination'));
        }

        for (var i = 1; i <= nbPages; i++) {
          $("<li class=\"page-item\"><a class=\"page-link\" data-page=\"".concat(i, "\" href=\"javascript:void(0)\">").concat(i, "</a></li>")).appendTo($('ul.pagination'));
        }

        page = parseInt(page);

        if (page + 1 && page < nbPages) {
          $("<li class=\"page-item\"><a class=\"page-link\" data-page=\"".concat(parseInt(page) + 1, "\" href=\"javascript:void(0)\">Next</a></li>")).appendTo($('ul.pagination'));
        }

        $.each(result["hydra:member"], function (i, card) {
          //console.log(result);
          var classementDatas = '<tr><td scope="row">' + card.user.firstname + ' ' + card.user.lastname + '</td> ' + '<td scope="row" class="text-center">' + card.personalScore + '</td>' + '<td scope="row" class="text-center">' + card.countVictory + '/' + card.countGames + '</td>' + '<td scope="row" class="text-center">' + card.store.name + '</td></tr>';
          $("#results").append(classementDatas); //console.log(classementDatas);
        });
      },
      error: function error(result) {
        var error = '<tr><td colspan="4" class="text-center"> Le tableau est vide</td></tr>';
        $('#results').append(error);
        console.log('erreur réseau');
      }
    });
  }
});

/***/ })

},[["./assets/js/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsImdldFJhbmtpbmdzIiwib24iLCJlbXB0eSIsInBhZ2UiLCJhdHRyIiwiYWpheCIsInVybCIsInR5cGUiLCJzdWNjZXNzIiwicmVzdWx0IiwidG90YWxJdGVtcyIsIml0ZW1zUGVyUGFnZSIsIm5iUGFnZXMiLCJ0b0ZpeGVkIiwicGFyc2VJbnQiLCJhcHBlbmRUbyIsImkiLCJlYWNoIiwiY2FyZCIsImNsYXNzZW1lbnREYXRhcyIsInVzZXIiLCJmaXJzdG5hbWUiLCJsYXN0bmFtZSIsInBlcnNvbmFsU2NvcmUiLCJjb3VudFZpY3RvcnkiLCJjb3VudEdhbWVzIiwic3RvcmUiLCJuYW1lIiwiYXBwZW5kIiwiZXJyb3IiLCJjb25zb2xlIiwibG9nIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQSx1Qzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0FBOzs7Ozs7QUFPQTtBQUNBQSxtQkFBTyxDQUFDLDRDQUFELENBQVAsQyxDQUVBOzs7QUFDQSxJQUFNQyxDQUFDLEdBQUdELG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0NBRUE7QUFFQTs7QUFFQUMsQ0FBQyxDQUFDLFlBQVc7QUFFVDtBQUNBQyxhQUFXLEdBSEYsQ0FLVDs7QUFDQUQsR0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQkUsRUFBakIsQ0FBb0IsT0FBcEIsRUFBNkIsWUFBN0IsRUFBMkMsWUFBVztBQUVsREYsS0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjRyxLQUFkO0FBQ0EsUUFBTUMsSUFBSSxHQUFHSixDQUFDLENBQUMsSUFBRCxDQUFELENBQVFLLElBQVIsQ0FBYSxXQUFiLENBQWI7QUFDQUosZUFBVyxDQUFDRyxJQUFELENBQVg7QUFHSCxHQVBELEVBTlMsQ0FlVDs7QUFDQSxXQUFTSCxXQUFULEdBQStCO0FBQUEsUUFBVkcsSUFBVSx1RUFBSCxDQUFHO0FBQzNCSixLQUFDLENBQUNNLElBQUYsQ0FBTztBQUNIQyxTQUFHLEVBQUcsMEVBQTBFSCxJQUQ3RTtBQUNtRjtBQUN0RkksVUFBSSxFQUFHLEtBRko7QUFFVztBQUVkQyxhQUFPLEVBQUcsaUJBQVNDLE1BQVQsRUFBaUI7QUFFdkIsWUFBTUMsVUFBVSxHQUFHRCxNQUFNLENBQUMsa0JBQUQsQ0FBekI7QUFDQSxZQUFNRSxZQUFZLEdBQUcsQ0FBckI7QUFDQSxZQUFNQyxPQUFPLEdBQUcsQ0FBQ0YsVUFBVSxHQUFHQyxZQUFkLEVBQTRCRSxPQUE1QixDQUFvQyxDQUFwQyxDQUFoQjtBQUNBZCxTQUFDLENBQUMsYUFBRCxDQUFELENBQWlCRyxLQUFqQjs7QUFFQSxZQUFJQyxJQUFJLEdBQUUsQ0FBUCxJQUFhQSxJQUFJLElBQUlTLE9BQXhCLEVBQWdDO0FBQzVCYixXQUFDLHNFQUEwRGUsUUFBUSxDQUFDWCxJQUFELENBQVIsR0FBaUIsQ0FBM0Usc0RBQUQsQ0FBOEhZLFFBQTlILENBQXVJaEIsQ0FBQyxDQUFDLGVBQUQsQ0FBeEk7QUFDSDs7QUFFRCxhQUFLLElBQUlpQixDQUFDLEdBQUcsQ0FBYixFQUFnQkEsQ0FBQyxJQUFJSixPQUFyQixFQUE4QkksQ0FBQyxFQUEvQixFQUFtQztBQUUvQmpCLFdBQUMsc0VBQTBEaUIsQ0FBMUQsNENBQTBGQSxDQUExRixlQUFELENBQXlHRCxRQUF6RyxDQUFrSGhCLENBQUMsQ0FBQyxlQUFELENBQW5IO0FBRUg7O0FBQ0RJLFlBQUksR0FBR1csUUFBUSxDQUFDWCxJQUFELENBQWY7O0FBRUEsWUFBSUEsSUFBSSxHQUFDLENBQU4sSUFBWUEsSUFBSSxHQUFHUyxPQUF0QixFQUE4QjtBQUMxQmIsV0FBQyxzRUFBMERlLFFBQVEsQ0FBQ1gsSUFBRCxDQUFSLEdBQWlCLENBQTNFLGtEQUFELENBQTBIWSxRQUExSCxDQUFtSWhCLENBQUMsQ0FBQyxlQUFELENBQXBJO0FBQ0g7O0FBS0RBLFNBQUMsQ0FBQ2tCLElBQUYsQ0FBT1IsTUFBTSxDQUFDLGNBQUQsQ0FBYixFQUErQixVQUFVTyxDQUFWLEVBQWFFLElBQWIsRUFBbUI7QUFDOUM7QUFDQSxjQUFJQyxlQUFlLEdBQ2YseUJBQXlCRCxJQUFJLENBQUNFLElBQUwsQ0FBVUMsU0FBbkMsR0FBK0MsR0FBL0MsR0FBcURILElBQUksQ0FBQ0UsSUFBTCxDQUFVRSxRQUEvRCxHQUEyRSxRQUEzRSxHQUNBLHNDQURBLEdBQ3lDSixJQUFJLENBQUNLLGFBRDlDLEdBQzhELE9BRDlELEdBRUEsc0NBRkEsR0FFeUNMLElBQUksQ0FBQ00sWUFGOUMsR0FFOEQsR0FGOUQsR0FFb0VOLElBQUksQ0FBQ08sVUFGekUsR0FFc0YsT0FGdEYsR0FHQSxzQ0FIQSxHQUd5Q1AsSUFBSSxDQUFDUSxLQUFMLENBQVdDLElBSHBELEdBRzJELFlBSi9EO0FBS0E1QixXQUFDLENBQUMsVUFBRCxDQUFELENBQWM2QixNQUFkLENBQXFCVCxlQUFyQixFQVA4QyxDQVE5QztBQUNILFNBVEQ7QUFVSCxPQXZDRTtBQXdDSFUsV0FBSyxFQUFHLGVBQVNwQixNQUFULEVBQWlCO0FBQ3JCLFlBQUlvQixLQUFLLEdBQ0wsd0VBREo7QUFFQTlCLFNBQUMsQ0FBQyxVQUFELENBQUQsQ0FBYzZCLE1BQWQsQ0FBcUJDLEtBQXJCO0FBQ0FDLGVBQU8sQ0FBQ0MsR0FBUixDQUFZLGVBQVo7QUFDSDtBQTdDRSxLQUFQO0FBK0NIO0FBRUosQ0FsRUEsQ0FBRCxDIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG4vLyBhbnkgQ1NTIHlvdSByZXF1aXJlIHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxucmVxdWlyZSgnLi4vY3NzL2FwcC5jc3MnKTtcblxuLy8gTmVlZCBqUXVlcnk/IEluc3RhbGwgaXQgd2l0aCBcInlhcm4gYWRkIGpxdWVyeVwiLCB0aGVuIHVuY29tbWVudCB0byByZXF1aXJlIGl0LlxuY29uc3QgJCA9IHJlcXVpcmUoJ2pxdWVyeScpO1xuaW1wb3J0ICdib290c3RyYXAnO1xuLy9pbXBvcnQgJy4uL2pzL2FwaS5qcyc7XG5cbi8vY29uc29sZS5sb2coJ0hlbGxvIFdlYnBhY2sgRW5jb3JlISBFZGl0IG1lIGluIGFzc2V0cy9qcy9hcHAuanMnKTtcblxuJChmdW5jdGlvbigpIHtcblxuICAgIC8vIEluaXQgcmFua2luZyBwcm9jZXNzXG4gICAgZ2V0UmFua2luZ3MoKTtcblxuICAgIC8vIENhbGxlZCBvbiBwYWdpbmF0aW9uIGNoYW5nZVxuICAgICQoJy5wYWdpbmF0aW9uJykub24oXCJjbGlja1wiLCBcIi5wYWdlLWxpbmtcIiwgZnVuY3Rpb24oKSB7XG5cbiAgICAgICAgJCgnI3Jlc3VsdHMnKS5lbXB0eSgpO1xuICAgICAgICBjb25zdCBwYWdlID0gJCh0aGlzKS5hdHRyKCdkYXRhLXBhZ2UnKTtcbiAgICAgICAgZ2V0UmFua2luZ3MocGFnZSk7XG5cblxuICAgIH0pO1xuXG4gICAgLy8gU3RhcnQgYWpheCBjYWxsXG4gICAgZnVuY3Rpb24gZ2V0UmFua2luZ3MocGFnZSA9IDEpIHtcbiAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgIHVybCA6ICcvYXBpL2NhcmRzLmpzb25sZD9vcmRlciU1QnBlcnNvbmFsU2NvcmUlNUQ9ZGVzYyZwYWdpbmF0aW9uPXRydWUmcGFnZT0nICsgcGFnZSwgLy8gTGEgcmVzc291cmNlIGNpYmzDqWVcbiAgICAgICAgICAgIHR5cGUgOiAnR0VUJywgLy8gTGUgdHlwZSBkZSBsYSByZXF1w6p0ZSBIVFRQXG5cbiAgICAgICAgICAgIHN1Y2Nlc3MgOiBmdW5jdGlvbihyZXN1bHQpIHtcblxuICAgICAgICAgICAgICAgIGNvbnN0IHRvdGFsSXRlbXMgPSByZXN1bHRbXCJoeWRyYTp0b3RhbEl0ZW1zXCJdO1xuICAgICAgICAgICAgICAgIGNvbnN0IGl0ZW1zUGVyUGFnZSA9IDU7XG4gICAgICAgICAgICAgICAgY29uc3QgbmJQYWdlcyA9ICh0b3RhbEl0ZW1zIC8gaXRlbXNQZXJQYWdlKS50b0ZpeGVkKDApO1xuICAgICAgICAgICAgICAgICQoJy5wYWdpbmF0aW9uJykuZW1wdHkoKTtcblxuICAgICAgICAgICAgICAgIGlmKChwYWdlIC0xKSAmJiBwYWdlIDw9IG5iUGFnZXMpe1xuICAgICAgICAgICAgICAgICAgICAkKGA8bGkgY2xhc3M9XCJwYWdlLWl0ZW1cIj48YSBjbGFzcz1cInBhZ2UtbGlua1wiIGRhdGEtcGFnZT1cIiR7cGFyc2VJbnQocGFnZSkgLSAxfVwiIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj5QcmV2aW91czwvYT48L2xpPmApLmFwcGVuZFRvKCQoJ3VsLnBhZ2luYXRpb24nKSk7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgZm9yIChsZXQgaSA9IDE7IGkgPD0gbmJQYWdlczsgaSsrKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgJChgPGxpIGNsYXNzPVwicGFnZS1pdGVtXCI+PGEgY2xhc3M9XCJwYWdlLWxpbmtcIiBkYXRhLXBhZ2U9XCIke2l9XCIgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPiR7aX08L2E+PC9saT5gKS5hcHBlbmRUbygkKCd1bC5wYWdpbmF0aW9uJykpO1xuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIHBhZ2UgPSBwYXJzZUludChwYWdlKTtcblxuICAgICAgICAgICAgICAgIGlmKChwYWdlKzEpICYmIHBhZ2UgPCBuYlBhZ2VzKXtcbiAgICAgICAgICAgICAgICAgICAgJChgPGxpIGNsYXNzPVwicGFnZS1pdGVtXCI+PGEgY2xhc3M9XCJwYWdlLWxpbmtcIiBkYXRhLXBhZ2U9XCIke3BhcnNlSW50KHBhZ2UpICsgMX1cIiBocmVmPVwiamF2YXNjcmlwdDp2b2lkKDApXCI+TmV4dDwvYT48L2xpPmApLmFwcGVuZFRvKCQoJ3VsLnBhZ2luYXRpb24nKSk7XG4gICAgICAgICAgICAgICAgfVxuXG5cblxuXG4gICAgICAgICAgICAgICAgJC5lYWNoKHJlc3VsdFtcImh5ZHJhOm1lbWJlclwiXSwgZnVuY3Rpb24gKGksIGNhcmQpIHtcbiAgICAgICAgICAgICAgICAgICAgLy9jb25zb2xlLmxvZyhyZXN1bHQpO1xuICAgICAgICAgICAgICAgICAgICBsZXQgY2xhc3NlbWVudERhdGFzID1cbiAgICAgICAgICAgICAgICAgICAgICAgICc8dHI+PHRkIHNjb3BlPVwicm93XCI+JyArIGNhcmQudXNlci5maXJzdG5hbWUgKyAnICcgKyBjYXJkLnVzZXIubGFzdG5hbWUgKyAgJzwvdGQ+ICcgK1xuICAgICAgICAgICAgICAgICAgICAgICAgJzx0ZCBzY29wZT1cInJvd1wiIGNsYXNzPVwidGV4dC1jZW50ZXJcIj4nICsgY2FyZC5wZXJzb25hbFNjb3JlICsgJzwvdGQ+JyArXG4gICAgICAgICAgICAgICAgICAgICAgICAnPHRkIHNjb3BlPVwicm93XCIgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiPicgKyBjYXJkLmNvdW50VmljdG9yeSAgKyAnLycgKyBjYXJkLmNvdW50R2FtZXMgKyAnPC90ZD4nICtcbiAgICAgICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtY2VudGVyXCI+JyArIGNhcmQuc3RvcmUubmFtZSArICc8L3RkPjwvdHI+JztcbiAgICAgICAgICAgICAgICAgICAgJChcIiNyZXN1bHRzXCIpLmFwcGVuZChjbGFzc2VtZW50RGF0YXMpO1xuICAgICAgICAgICAgICAgICAgICAvL2NvbnNvbGUubG9nKGNsYXNzZW1lbnREYXRhcyk7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBlcnJvciA6IGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICAgICAgICAgIGxldCBlcnJvciA9XG4gICAgICAgICAgICAgICAgICAgICc8dHI+PHRkIGNvbHNwYW49XCI0XCIgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiPiBMZSB0YWJsZWF1IGVzdCB2aWRlPC90ZD48L3RyPic7XG4gICAgICAgICAgICAgICAgJCgnI3Jlc3VsdHMnKS5hcHBlbmQoZXJyb3IpO1xuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdlcnJldXIgcsOpc2VhdScpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9XG4gICAgXG59KTsiXSwic291cmNlUm9vdCI6IiJ9