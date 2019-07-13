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

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
$(function () {
  $.ajax({
    url: '/api/cards.json?order%5BpersonalScore%5D=desc',
    // La ressource ciblée
    type: 'GET',
    // Le type de la requête HTTP
    success: function success(result) {
      $.each(result, function (i, card) {
        console.log(result);
        var classementDatas = '<tr><td scope="row" class="text-white">' + card.user.firstname + ' ' + card.user.lastname + '</td> ' + '<td scope="row" class="text-white text-center">' + card.personalScore + '</td>' + '<td scope="row" class="text-white text-center">' + card.countVictory + '/' + card.countGames + '</td>' + '<td scope="row" class="text-white text-center">' + card.store.name + '</td></tr>';
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsImNvbnNvbGUiLCJsb2ciLCJhamF4IiwidXJsIiwidHlwZSIsInN1Y2Nlc3MiLCJyZXN1bHQiLCJlYWNoIiwiaSIsImNhcmQiLCJjbGFzc2VtZW50RGF0YXMiLCJ1c2VyIiwiZmlyc3RuYW1lIiwibGFzdG5hbWUiLCJwZXJzb25hbFNjb3JlIiwiY291bnRWaWN0b3J5IiwiY291bnRHYW1lcyIsInN0b3JlIiwibmFtZSIsImFwcGVuZCIsImVycm9yIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQSx1Qzs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0FBOzs7Ozs7QUFPQTtBQUNBQSxtQkFBTyxDQUFDLDRDQUFELENBQVAsQyxDQUVBOzs7QUFDQSxJQUFNQyxDQUFDLEdBQUdELG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0NBRUE7O0FBRUFFLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLG1EQUFaO0FBRUFGLENBQUMsQ0FBQyxZQUFXO0FBQ1RBLEdBQUMsQ0FBQ0csSUFBRixDQUFPO0FBQ0hDLE9BQUcsRUFBRywrQ0FESDtBQUNvRDtBQUN2REMsUUFBSSxFQUFHLEtBRko7QUFFVztBQUVkQyxXQUFPLEVBQUcsaUJBQVNDLE1BQVQsRUFBaUI7QUFDdkJQLE9BQUMsQ0FBQ1EsSUFBRixDQUFPRCxNQUFQLEVBQWUsVUFBVUUsQ0FBVixFQUFhQyxJQUFiLEVBQW1CO0FBQzlCVCxlQUFPLENBQUNDLEdBQVIsQ0FBWUssTUFBWjtBQUNBLFlBQUlJLGVBQWUsR0FDZiw0Q0FBNENELElBQUksQ0FBQ0UsSUFBTCxDQUFVQyxTQUF0RCxHQUFrRSxHQUFsRSxHQUF3RUgsSUFBSSxDQUFDRSxJQUFMLENBQVVFLFFBQWxGLEdBQThGLFFBQTlGLEdBQ0EsaURBREEsR0FDb0RKLElBQUksQ0FBQ0ssYUFEekQsR0FDeUUsT0FEekUsR0FFQSxpREFGQSxHQUVvREwsSUFBSSxDQUFDTSxZQUZ6RCxHQUV5RSxHQUZ6RSxHQUUrRU4sSUFBSSxDQUFDTyxVQUZwRixHQUVpRyxPQUZqRyxHQUdBLGlEQUhBLEdBR29EUCxJQUFJLENBQUNRLEtBQUwsQ0FBV0MsSUFIL0QsR0FHc0UsWUFKMUU7QUFLQW5CLFNBQUMsQ0FBQyxVQUFELENBQUQsQ0FBY29CLE1BQWQsQ0FBcUJULGVBQXJCO0FBQ0FWLGVBQU8sQ0FBQ0MsR0FBUixDQUFZUyxlQUFaO0FBQ0gsT0FURDtBQVVILEtBZkU7QUFnQkhVLFNBQUssRUFBRyxlQUFTZCxNQUFULEVBQWlCO0FBQ3JCLFVBQUljLEtBQUssR0FDTCwwQ0FESjtBQUVBckIsT0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjb0IsTUFBZCxDQUFxQkMsS0FBckI7QUFDQXBCLGFBQU8sQ0FBQ0MsR0FBUixDQUFZLGVBQVo7QUFDSDtBQXJCRSxHQUFQO0FBdUJILENBeEJBLENBQUQsQyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iLCIvKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcbiAqIChhbmQgaXRzIENTUyBmaWxlKSBpbiB5b3VyIGJhc2UgbGF5b3V0IChiYXNlLmh0bWwudHdpZykuXG4gKi9cblxuLy8gYW55IENTUyB5b3UgcmVxdWlyZSB3aWxsIG91dHB1dCBpbnRvIGEgc2luZ2xlIGNzcyBmaWxlIChhcHAuY3NzIGluIHRoaXMgY2FzZSlcbnJlcXVpcmUoJy4uL2Nzcy9hcHAuY3NzJyk7XG5cbi8vIE5lZWQgalF1ZXJ5PyBJbnN0YWxsIGl0IHdpdGggXCJ5YXJuIGFkZCBqcXVlcnlcIiwgdGhlbiB1bmNvbW1lbnQgdG8gcmVxdWlyZSBpdC5cbmNvbnN0ICQgPSByZXF1aXJlKCdqcXVlcnknKTtcbmltcG9ydCAnYm9vdHN0cmFwJztcbi8vaW1wb3J0ICcuLi9qcy9hcGkuanMnO1xuXG5jb25zb2xlLmxvZygnSGVsbG8gV2VicGFjayBFbmNvcmUhIEVkaXQgbWUgaW4gYXNzZXRzL2pzL2FwcC5qcycpO1xuXG4kKGZ1bmN0aW9uKCkge1xuICAgICQuYWpheCh7XG4gICAgICAgIHVybCA6ICcvYXBpL2NhcmRzLmpzb24/b3JkZXIlNUJwZXJzb25hbFNjb3JlJTVEPWRlc2MnLCAvLyBMYSByZXNzb3VyY2UgY2libMOpZVxuICAgICAgICB0eXBlIDogJ0dFVCcsIC8vIExlIHR5cGUgZGUgbGEgcmVxdcOqdGUgSFRUUFxuXG4gICAgICAgIHN1Y2Nlc3MgOiBmdW5jdGlvbihyZXN1bHQpIHtcbiAgICAgICAgICAgICQuZWFjaChyZXN1bHQsIGZ1bmN0aW9uIChpLCBjYXJkKSB7XG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2cocmVzdWx0KTtcbiAgICAgICAgICAgICAgICBsZXQgY2xhc3NlbWVudERhdGFzID1cbiAgICAgICAgICAgICAgICAgICAgJzx0cj48dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtd2hpdGVcIj4nICsgY2FyZC51c2VyLmZpcnN0bmFtZSArICcgJyArIGNhcmQudXNlci5sYXN0bmFtZSArICAnPC90ZD4gJyArXG4gICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtd2hpdGUgdGV4dC1jZW50ZXJcIj4nICsgY2FyZC5wZXJzb25hbFNjb3JlICsgJzwvdGQ+JyArXG4gICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtd2hpdGUgdGV4dC1jZW50ZXJcIj4nICsgY2FyZC5jb3VudFZpY3RvcnkgICsgJy8nICsgY2FyZC5jb3VudEdhbWVzICsgJzwvdGQ+JyArXG4gICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtd2hpdGUgdGV4dC1jZW50ZXJcIj4nICsgY2FyZC5zdG9yZS5uYW1lICsgJzwvdGQ+PC90cj4nO1xuICAgICAgICAgICAgICAgICQoXCIjcmVzdWx0c1wiKS5hcHBlbmQoY2xhc3NlbWVudERhdGFzKTtcbiAgICAgICAgICAgICAgICBjb25zb2xlLmxvZyhjbGFzc2VtZW50RGF0YXMpO1xuICAgICAgICAgICAgfSlcbiAgICAgICAgfSxcbiAgICAgICAgZXJyb3IgOiBmdW5jdGlvbihyZXN1bHQpIHtcbiAgICAgICAgICAgIGxldCBlcnJvciA9XG4gICAgICAgICAgICAgICAgJzx0aCBzY29wZT1cInJvd1wiPiBPdXBzLi4uIHVuZSBlcnJldXI8L3RoPic7XG4gICAgICAgICAgICAkKCcjcmVzdWx0cycpLmFwcGVuZChlcnJvcik7XG4gICAgICAgICAgICBjb25zb2xlLmxvZygnZXJyZXVyIHLDqXNlYXUnKTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7Il0sInNvdXJjZVJvb3QiOiIifQ==