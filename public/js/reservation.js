/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/reservation.js ***!
  \*************************************/
$(function () {
  // フラッシュメッセージ表示
  if (isSuccessedReservation) {
    $('#successedReservation').modal();
  }

  if (isFailedReservation) {
    $('#failedReservation').modal();
  }

  if (isCanceledReservation) {
    $('#reservationCancel').modal();
  }
}); // 対象日の予約時間表示

$('.day-ok').click(function () {
  $avaTime = $('#jsAvaTime');
  var date = $(this).data('date');
  $requestedAvaDate = $('#jsRequestedAvaDate');
  $requestedAvaDate.val(date);
  var timesPerTargetDate = avaTimes[date];

  for (i = 0; i < timesPerTargetDate.length; i++) {
    $avaTime.append("<button class=\"btn mb-3 ava-time\">".concat(timesPerTargetDate[i], "</button>"));
  }

  $('#avaTimeModal').modal();
}); // 利用時間選択モーダル閉じた時、利用時間をリセット
// ※再度、本モーダルを開くたび、時間が追加されていくため

$('#avaTimeModal').on('hidden.bs.modal', function () {
  $('.ava-time').remove();
}); // appendで追加した要素は、dom要素.clickでのクリックイベントは効かない
// なので、on関数を使ってクリックイベントを発火させる

$(document).on("click", ".ava-time", function () {
  var avaDate = $('#jsRequestedAvaDate').val();
  var avaTime = $(this).text();
  var formatedDateTime = getFormatedDateTime(avaDate, avaTime);
  var isDoneReservation = confirm(formatedDateTime + 'に予約してよろしいですか？');

  if (isDoneReservation) {
    $requestedAvaTime = $('#jsRequestedAvaTime');
    $requestedAvaTime.val(avaTime);
    $('#jsAvaTimeForm').trigger('submit');
  }
});

function getFormatedDateTime(avaDate, avaTime) {
  var month = avaDate.slice(5, 7) + '月';
  var day = avaDate.slice(8, 10) + '日';
  var hour = avaTime.slice(0, 2) + '時';
  return month + day + hour;
}
/******/ })()
;