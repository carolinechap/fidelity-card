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
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_1__);


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
  $.ajax({
    url: '/api/cards.json?order%5BpersonalScore%5D=desc',
    // La ressource ciblée
    type: 'GET',
    // Le type de la requête HTTP
    success: function success(result) {
      $.each(result, function (i, card) {
        console.log(result);
        var classementDatas = '<tr><td scope="row">' + card.user.firstname + ' ' + card.user.lastname + '</td> ' + '<td scope="row" class="text-center">' + card.personalScore + '</td>' + '<td scope="row" class="text-center">' + card.countVictory + '/' + card.countGames + '</td>' + '<td scope="row" class="text-center">' + card.store.name + '</td></tr>';
        $("#results").append(classementDatas);
        console.log(classementDatas);
      });
    },
    error: function error(result) {
      var error = '<th scope="row"> Oups... une erreur</th>';
      $('#results').append(error);
      console.log('erreur réseau');
    }
  });
});

/***/ })

},[["./assets/js/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsImFqYXgiLCJ1cmwiLCJ0eXBlIiwic3VjY2VzcyIsInJlc3VsdCIsImVhY2giLCJpIiwiY2FyZCIsImNvbnNvbGUiLCJsb2ciLCJjbGFzc2VtZW50RGF0YXMiLCJ1c2VyIiwiZmlyc3RuYW1lIiwibGFzdG5hbWUiLCJwZXJzb25hbFNjb3JlIiwiY291bnRWaWN0b3J5IiwiY291bnRHYW1lcyIsInN0b3JlIiwibmFtZSIsImFwcGVuZCIsImVycm9yIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQSx1Qzs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0FBOzs7Ozs7QUFPQTtBQUNBQSxtQkFBTyxDQUFDLDRDQUFELENBQVAsQyxDQUVBOzs7QUFDQSxJQUFNQyxDQUFDLEdBQUdELG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0NBRUE7QUFFQTs7QUFFQUMsQ0FBQyxDQUFDLFlBQVc7QUFDVEEsR0FBQyxDQUFDQyxJQUFGLENBQU87QUFDSEMsT0FBRyxFQUFHLCtDQURIO0FBQ29EO0FBQ3ZEQyxRQUFJLEVBQUcsS0FGSjtBQUVXO0FBRWRDLFdBQU8sRUFBRyxpQkFBU0MsTUFBVCxFQUFpQjtBQUN2QkwsT0FBQyxDQUFDTSxJQUFGLENBQU9ELE1BQVAsRUFBZSxVQUFVRSxDQUFWLEVBQWFDLElBQWIsRUFBbUI7QUFDOUJDLGVBQU8sQ0FBQ0MsR0FBUixDQUFZTCxNQUFaO0FBQ0EsWUFBSU0sZUFBZSxHQUNmLHlCQUF5QkgsSUFBSSxDQUFDSSxJQUFMLENBQVVDLFNBQW5DLEdBQStDLEdBQS9DLEdBQXFETCxJQUFJLENBQUNJLElBQUwsQ0FBVUUsUUFBL0QsR0FBMkUsUUFBM0UsR0FDQSxzQ0FEQSxHQUN5Q04sSUFBSSxDQUFDTyxhQUQ5QyxHQUM4RCxPQUQ5RCxHQUVBLHNDQUZBLEdBRXlDUCxJQUFJLENBQUNRLFlBRjlDLEdBRThELEdBRjlELEdBRW9FUixJQUFJLENBQUNTLFVBRnpFLEdBRXNGLE9BRnRGLEdBR0Esc0NBSEEsR0FHeUNULElBQUksQ0FBQ1UsS0FBTCxDQUFXQyxJQUhwRCxHQUcyRCxZQUovRDtBQUtBbkIsU0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjb0IsTUFBZCxDQUFxQlQsZUFBckI7QUFDQUYsZUFBTyxDQUFDQyxHQUFSLENBQVlDLGVBQVo7QUFDSCxPQVREO0FBVUgsS0FmRTtBQWdCSFUsU0FBSyxFQUFHLGVBQVNoQixNQUFULEVBQWlCO0FBQ3JCLFVBQUlnQixLQUFLLEdBQ0wsMENBREo7QUFFQXJCLE9BQUMsQ0FBQyxVQUFELENBQUQsQ0FBY29CLE1BQWQsQ0FBcUJDLEtBQXJCO0FBQ0FaLGFBQU8sQ0FBQ0MsR0FBUixDQUFZLGVBQVo7QUFDSDtBQXJCRSxHQUFQO0FBdUJILENBeEJBLENBQUQsQyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iLCIvKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcbiAqIChhbmQgaXRzIENTUyBmaWxlKSBpbiB5b3VyIGJhc2UgbGF5b3V0IChiYXNlLmh0bWwudHdpZykuXG4gKi9cblxuLy8gYW55IENTUyB5b3UgcmVxdWlyZSB3aWxsIG91dHB1dCBpbnRvIGEgc2luZ2xlIGNzcyBmaWxlIChhcHAuY3NzIGluIHRoaXMgY2FzZSlcbnJlcXVpcmUoJy4uL2Nzcy9hcHAuY3NzJyk7XG5cbi8vIE5lZWQgalF1ZXJ5PyBJbnN0YWxsIGl0IHdpdGggXCJ5YXJuIGFkZCBqcXVlcnlcIiwgdGhlbiB1bmNvbW1lbnQgdG8gcmVxdWlyZSBpdC5cbmNvbnN0ICQgPSByZXF1aXJlKCdqcXVlcnknKTtcbmltcG9ydCAnYm9vdHN0cmFwJztcbi8vaW1wb3J0ICcuLi9qcy9hcGkuanMnO1xuXG4vL2NvbnNvbGUubG9nKCdIZWxsbyBXZWJwYWNrIEVuY29yZSEgRWRpdCBtZSBpbiBhc3NldHMvanMvYXBwLmpzJyk7XG5cbiQoZnVuY3Rpb24oKSB7XG4gICAgJC5hamF4KHtcbiAgICAgICAgdXJsIDogJy9hcGkvY2FyZHMuanNvbj9vcmRlciU1QnBlcnNvbmFsU2NvcmUlNUQ9ZGVzYycsIC8vIExhIHJlc3NvdXJjZSBjaWJsw6llXG4gICAgICAgIHR5cGUgOiAnR0VUJywgLy8gTGUgdHlwZSBkZSBsYSByZXF1w6p0ZSBIVFRQXG5cbiAgICAgICAgc3VjY2VzcyA6IGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICAgICAgJC5lYWNoKHJlc3VsdCwgZnVuY3Rpb24gKGksIGNhcmQpIHtcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhyZXN1bHQpO1xuICAgICAgICAgICAgICAgIGxldCBjbGFzc2VtZW50RGF0YXMgPVxuICAgICAgICAgICAgICAgICAgICAnPHRyPjx0ZCBzY29wZT1cInJvd1wiPicgKyBjYXJkLnVzZXIuZmlyc3RuYW1lICsgJyAnICsgY2FyZC51c2VyLmxhc3RuYW1lICsgICc8L3RkPiAnICtcbiAgICAgICAgICAgICAgICAgICAgJzx0ZCBzY29wZT1cInJvd1wiIGNsYXNzPVwidGV4dC1jZW50ZXJcIj4nICsgY2FyZC5wZXJzb25hbFNjb3JlICsgJzwvdGQ+JyArXG4gICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtY2VudGVyXCI+JyArIGNhcmQuY291bnRWaWN0b3J5ICArICcvJyArIGNhcmQuY291bnRHYW1lcyArICc8L3RkPicgK1xuICAgICAgICAgICAgICAgICAgICAnPHRkIHNjb3BlPVwicm93XCIgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiPicgKyBjYXJkLnN0b3JlLm5hbWUgKyAnPC90ZD48L3RyPic7XG4gICAgICAgICAgICAgICAgJChcIiNyZXN1bHRzXCIpLmFwcGVuZChjbGFzc2VtZW50RGF0YXMpO1xuICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKGNsYXNzZW1lbnREYXRhcyk7XG4gICAgICAgICAgICB9KVxuICAgICAgICB9LFxuICAgICAgICBlcnJvciA6IGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICAgICAgbGV0IGVycm9yID1cbiAgICAgICAgICAgICAgICAnPHRoIHNjb3BlPVwicm93XCI+IE91cHMuLi4gdW5lIGVycmV1cjwvdGg+JztcbiAgICAgICAgICAgICQoJyNyZXN1bHRzJykuYXBwZW5kKGVycm9yKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdlcnJldXIgcsOpc2VhdScpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTsiXSwic291cmNlUm9vdCI6IiJ9