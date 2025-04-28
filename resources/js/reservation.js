$(function() {
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
})

// 対象日の予約時間表示
$('.day-ok').click(function() {
    $avaTime = $('#jsAvaTime');
    const date = $(this).data('date');
    $requestedAvaDate = $('#jsRequestedAvaDate');
    $requestedAvaDate.val(date);
    const timesPerTargetDate = avaTimes[date];
    for (i = 0; i < timesPerTargetDate.length; i++) {
        $avaTime.append(`<button class="btn mb-3 ava-time" id="jsAvaTimeBtn">${timesPerTargetDate[i]}</button>`);
    }
    $('#avaTimeModal').modal();
});

// 利用時間選択モーダル閉じた時、利用時間をリセット
// ※再度、本モーダルを開くたび、時間が追加されていくため
$('#avaTimeModal').on('hidden.bs.modal', function () {
    $('.ava-time').remove();
})

// appendで追加した要素は、dom要素.clickでのクリックイベントは効かない
// なので、on関数を使ってクリックイベントを発火させる
$(document).on("click",".ava-time", function() {
    const avaDate = $('#jsRequestedAvaDate').val();
    const avaTime = $(this).text();
    const formatedDateTime = getFormatedDateTime(avaDate, avaTime);
    const isDoneReservation = confirm(formatedDateTime + 'に予約してよろしいですか？');
    if (isDoneReservation) {
        $(this).prop("disabled", true);
        $requestedAvaTime = $('#jsRequestedAvaTime');
        const restoredTimeFormat = moment(avaTime, 'HH:mm:ss').format('HH:mm:ss'); // サーバ側でエラーにならないようフォーマットをもとに戻す
        $requestedAvaTime.val(restoredTimeFormat);
        $('#jsAvaTimeForm').trigger('submit');
    }
});

function getFormatedDateTime(avaDate, avaTime) {
    const month = avaDate.slice(5, 7) + '月';
    const day = avaDate.slice(8, 10) + '日';
    const hour = avaTime.slice(0, 2) + '時';
    const miniute = avaTime.slice(3, 5) + '分';
    return month + day + hour + miniute;
}
