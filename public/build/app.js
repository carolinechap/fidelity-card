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
    paging: true,
    pageLength: 5,
    url: '/api/cards.json?order%5BpersonalScore%5D=desc&pagination=true',
    // La ressource ciblée
    type: 'GET',
    // Le type de la requête HTTP
    success: function success(result) {
      $.each(result, function (i, card) {
        //console.log(result);
        var classementDatas = '<tr><td scope="row">' + card.user.firstname + ' ' + card.user.lastname + '</td> ' + '<td scope="row" class="text-center">' + card.personalScore + '</td>' + '<td scope="row" class="text-center">' + card.countVictory + '/' + card.countGames + '</td>' + '<td scope="row" class="text-center">' + card.store.name + '</td></tr>';
        $("#results").append(classementDatas); //console.log(classementDatas);
      });
    },
    error: function error(result) {
      var error = '<th scope="row"> Oups... une erreur</th>';
      $('#results').append(error);
      console.log('erreur réseau');
    }
  });
  $('#pagination').pagination({
    dataSource: 'https://api.flickr.com/services/feeds/photos_public.gne?tags=cat&tagmode=any&format=json&jsoncallback=?',
    locator: 'items',
    totalNumber: 120,
    pageSize: 20,
    ajax: {
      beforeSend: function beforeSend() {
        dataContainer.html('Loading data from flickr.com ...');
      }
    },
    callback: function callback(data, pagination) {
      // template method of yourself
      var html = template(data);
      dataContainer.html(html);
    }
  });
});

/***/ })

},[["./assets/js/app.js","runtime","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2FwcC5jc3MiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL2FwcC5qcyJdLCJuYW1lcyI6WyJyZXF1aXJlIiwiJCIsImFqYXgiLCJwYWdpbmciLCJwYWdlTGVuZ3RoIiwidXJsIiwidHlwZSIsInN1Y2Nlc3MiLCJyZXN1bHQiLCJlYWNoIiwiaSIsImNhcmQiLCJjbGFzc2VtZW50RGF0YXMiLCJ1c2VyIiwiZmlyc3RuYW1lIiwibGFzdG5hbWUiLCJwZXJzb25hbFNjb3JlIiwiY291bnRWaWN0b3J5IiwiY291bnRHYW1lcyIsInN0b3JlIiwibmFtZSIsImFwcGVuZCIsImVycm9yIiwiY29uc29sZSIsImxvZyIsInBhZ2luYXRpb24iLCJkYXRhU291cmNlIiwibG9jYXRvciIsInRvdGFsTnVtYmVyIiwicGFnZVNpemUiLCJiZWZvcmVTZW5kIiwiZGF0YUNvbnRhaW5lciIsImh0bWwiLCJjYWxsYmFjayIsImRhdGEiLCJ0ZW1wbGF0ZSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUEsdUM7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNBQTs7Ozs7O0FBT0E7QUFDQUEsbUJBQU8sQ0FBQyw0Q0FBRCxDQUFQLEMsQ0FFQTs7O0FBQ0EsSUFBTUMsQ0FBQyxHQUFHRCxtQkFBTyxDQUFDLG9EQUFELENBQWpCOztDQUVBO0FBRUE7O0FBRUFDLENBQUMsQ0FBQyxZQUFXO0FBQ1RBLEdBQUMsQ0FBQ0MsSUFBRixDQUFPO0FBQ0hDLFVBQU0sRUFBRSxJQURMO0FBRUhDLGNBQVUsRUFBRSxDQUZUO0FBR0hDLE9BQUcsRUFBRywrREFISDtBQUdvRTtBQUN2RUMsUUFBSSxFQUFHLEtBSko7QUFJVztBQUVkQyxXQUFPLEVBQUcsaUJBQVNDLE1BQVQsRUFBaUI7QUFDdkJQLE9BQUMsQ0FBQ1EsSUFBRixDQUFPRCxNQUFQLEVBQWUsVUFBVUUsQ0FBVixFQUFhQyxJQUFiLEVBQW1CO0FBQzlCO0FBQ0EsWUFBSUMsZUFBZSxHQUNmLHlCQUF5QkQsSUFBSSxDQUFDRSxJQUFMLENBQVVDLFNBQW5DLEdBQStDLEdBQS9DLEdBQXFESCxJQUFJLENBQUNFLElBQUwsQ0FBVUUsUUFBL0QsR0FBMkUsUUFBM0UsR0FDQSxzQ0FEQSxHQUN5Q0osSUFBSSxDQUFDSyxhQUQ5QyxHQUM4RCxPQUQ5RCxHQUVBLHNDQUZBLEdBRXlDTCxJQUFJLENBQUNNLFlBRjlDLEdBRThELEdBRjlELEdBRW9FTixJQUFJLENBQUNPLFVBRnpFLEdBRXNGLE9BRnRGLEdBR0Esc0NBSEEsR0FHeUNQLElBQUksQ0FBQ1EsS0FBTCxDQUFXQyxJQUhwRCxHQUcyRCxZQUovRDtBQUtBbkIsU0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjb0IsTUFBZCxDQUFxQlQsZUFBckIsRUFQOEIsQ0FROUI7QUFDSCxPQVREO0FBVUgsS0FqQkU7QUFrQkhVLFNBQUssRUFBRyxlQUFTZCxNQUFULEVBQWlCO0FBQ3JCLFVBQUljLEtBQUssR0FDTCwwQ0FESjtBQUVBckIsT0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjb0IsTUFBZCxDQUFxQkMsS0FBckI7QUFDQUMsYUFBTyxDQUFDQyxHQUFSLENBQVksZUFBWjtBQUNIO0FBdkJFLEdBQVA7QUF5QkF2QixHQUFDLENBQUMsYUFBRCxDQUFELENBQWlCd0IsVUFBakIsQ0FBNEI7QUFDeEJDLGNBQVUsRUFBRSx5R0FEWTtBQUV4QkMsV0FBTyxFQUFFLE9BRmU7QUFHeEJDLGVBQVcsRUFBRSxHQUhXO0FBSXhCQyxZQUFRLEVBQUUsRUFKYztBQUt4QjNCLFFBQUksRUFBRTtBQUNGNEIsZ0JBQVUsRUFBRSxzQkFBVztBQUNuQkMscUJBQWEsQ0FBQ0MsSUFBZCxDQUFtQixrQ0FBbkI7QUFDSDtBQUhDLEtBTGtCO0FBVXhCQyxZQUFRLEVBQUUsa0JBQVNDLElBQVQsRUFBZVQsVUFBZixFQUEyQjtBQUNqQztBQUNBLFVBQUlPLElBQUksR0FBR0csUUFBUSxDQUFDRCxJQUFELENBQW5CO0FBQ0FILG1CQUFhLENBQUNDLElBQWQsQ0FBbUJBLElBQW5CO0FBQ0g7QUFkdUIsR0FBNUI7QUFnQkgsQ0ExQ0EsQ0FBRCxDIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG4vLyBhbnkgQ1NTIHlvdSByZXF1aXJlIHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxucmVxdWlyZSgnLi4vY3NzL2FwcC5jc3MnKTtcblxuLy8gTmVlZCBqUXVlcnk/IEluc3RhbGwgaXQgd2l0aCBcInlhcm4gYWRkIGpxdWVyeVwiLCB0aGVuIHVuY29tbWVudCB0byByZXF1aXJlIGl0LlxuY29uc3QgJCA9IHJlcXVpcmUoJ2pxdWVyeScpO1xuaW1wb3J0ICdib290c3RyYXAnO1xuLy9pbXBvcnQgJy4uL2pzL2FwaS5qcyc7XG5cbi8vY29uc29sZS5sb2coJ0hlbGxvIFdlYnBhY2sgRW5jb3JlISBFZGl0IG1lIGluIGFzc2V0cy9qcy9hcHAuanMnKTtcblxuJChmdW5jdGlvbigpIHtcbiAgICAkLmFqYXgoe1xuICAgICAgICBwYWdpbmc6IHRydWUsXG4gICAgICAgIHBhZ2VMZW5ndGg6IDUsXG4gICAgICAgIHVybCA6ICcvYXBpL2NhcmRzLmpzb24/b3JkZXIlNUJwZXJzb25hbFNjb3JlJTVEPWRlc2MmcGFnaW5hdGlvbj10cnVlJywgLy8gTGEgcmVzc291cmNlIGNpYmzDqWVcbiAgICAgICAgdHlwZSA6ICdHRVQnLCAvLyBMZSB0eXBlIGRlIGxhIHJlcXXDqnRlIEhUVFBcblxuICAgICAgICBzdWNjZXNzIDogZnVuY3Rpb24ocmVzdWx0KSB7XG4gICAgICAgICAgICAkLmVhY2gocmVzdWx0LCBmdW5jdGlvbiAoaSwgY2FyZCkge1xuICAgICAgICAgICAgICAgIC8vY29uc29sZS5sb2cocmVzdWx0KTtcbiAgICAgICAgICAgICAgICBsZXQgY2xhc3NlbWVudERhdGFzID1cbiAgICAgICAgICAgICAgICAgICAgJzx0cj48dGQgc2NvcGU9XCJyb3dcIj4nICsgY2FyZC51c2VyLmZpcnN0bmFtZSArICcgJyArIGNhcmQudXNlci5sYXN0bmFtZSArICAnPC90ZD4gJyArXG4gICAgICAgICAgICAgICAgICAgICc8dGQgc2NvcGU9XCJyb3dcIiBjbGFzcz1cInRleHQtY2VudGVyXCI+JyArIGNhcmQucGVyc29uYWxTY29yZSArICc8L3RkPicgK1xuICAgICAgICAgICAgICAgICAgICAnPHRkIHNjb3BlPVwicm93XCIgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiPicgKyBjYXJkLmNvdW50VmljdG9yeSAgKyAnLycgKyBjYXJkLmNvdW50R2FtZXMgKyAnPC90ZD4nICtcbiAgICAgICAgICAgICAgICAgICAgJzx0ZCBzY29wZT1cInJvd1wiIGNsYXNzPVwidGV4dC1jZW50ZXJcIj4nICsgY2FyZC5zdG9yZS5uYW1lICsgJzwvdGQ+PC90cj4nO1xuICAgICAgICAgICAgICAgICQoXCIjcmVzdWx0c1wiKS5hcHBlbmQoY2xhc3NlbWVudERhdGFzKTtcbiAgICAgICAgICAgICAgICAvL2NvbnNvbGUubG9nKGNsYXNzZW1lbnREYXRhcyk7XG4gICAgICAgICAgICB9KVxuICAgICAgICB9LFxuICAgICAgICBlcnJvciA6IGZ1bmN0aW9uKHJlc3VsdCkge1xuICAgICAgICAgICAgbGV0IGVycm9yID1cbiAgICAgICAgICAgICAgICAnPHRoIHNjb3BlPVwicm93XCI+IE91cHMuLi4gdW5lIGVycmV1cjwvdGg+JztcbiAgICAgICAgICAgICQoJyNyZXN1bHRzJykuYXBwZW5kKGVycm9yKTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdlcnJldXIgcsOpc2VhdScpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgJCgnI3BhZ2luYXRpb24nKS5wYWdpbmF0aW9uKHtcbiAgICAgICAgZGF0YVNvdXJjZTogJ2h0dHBzOi8vYXBpLmZsaWNrci5jb20vc2VydmljZXMvZmVlZHMvcGhvdG9zX3B1YmxpYy5nbmU/dGFncz1jYXQmdGFnbW9kZT1hbnkmZm9ybWF0PWpzb24manNvbmNhbGxiYWNrPT8nLFxuICAgICAgICBsb2NhdG9yOiAnaXRlbXMnLFxuICAgICAgICB0b3RhbE51bWJlcjogMTIwLFxuICAgICAgICBwYWdlU2l6ZTogMjAsXG4gICAgICAgIGFqYXg6IHtcbiAgICAgICAgICAgIGJlZm9yZVNlbmQ6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIGRhdGFDb250YWluZXIuaHRtbCgnTG9hZGluZyBkYXRhIGZyb20gZmxpY2tyLmNvbSAuLi4nKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSxcbiAgICAgICAgY2FsbGJhY2s6IGZ1bmN0aW9uKGRhdGEsIHBhZ2luYXRpb24pIHtcbiAgICAgICAgICAgIC8vIHRlbXBsYXRlIG1ldGhvZCBvZiB5b3Vyc2VsZlxuICAgICAgICAgICAgdmFyIGh0bWwgPSB0ZW1wbGF0ZShkYXRhKTtcbiAgICAgICAgICAgIGRhdGFDb250YWluZXIuaHRtbChodG1sKTtcbiAgICAgICAgfVxuICAgIH0pXG59KTsiXSwic291cmNlUm9vdCI6IiJ9