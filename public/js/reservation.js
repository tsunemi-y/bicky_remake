/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/reservation.js ***!
  \*************************************/
$(function () {
  var $yesBtnLink = $('#firstCheckModal').find('#js-yesBtn');
  initUrl = $yesBtnLink.attr('href');
}); // 対象日の予約時間表示

$('.day-ok').click(function () {
  var day = $(this).data('day');
  var $dayStatus = $('.' + day);
  var $timeStatus = $('.time-status');
  $timeStatus.each(function (index, elm) {
    if ($(elm).hasClass('time-show')) {
      $(elm).removeClass('time-show');
      $(elm).addClass('time-hide');
    }
  });
  $dayStatus.removeClass('time-hide');
  $dayStatus.addClass('time-show');
});
$('.time-ok').click(function () {
  var $yesBtnLink = $('#js-yesBtn');
  var $noBtnLink = $('#js-noBtn');
  setQueryStr($(this), $yesBtnLink);
  setQueryStr($(this), $noBtnLink);
  $('#firstCheckModal').modal();
});
$('#js-yesBtn').click(function () {
  replaceQueryStr('yes', $(this), 'modalBtn=');
}); // クエリストリングセット

function setQueryStr(targetElm, modalBtn) {
  modalBtn.attr('href', initUrl);
  replaceQueryStr(targetElm.data('target_date'), modalBtn, 'targetDate=');
  replaceQueryStr(targetElm.data('target_time'), modalBtn, 'targetTime=');
} // クエリストリング置き換え


function replaceQueryStr(value, elm, key) {
  var url = elm.attr('href');
  var afterLink = url.replace(key, key + value);
  elm.attr('href', afterLink);
}
/******/ })()
;