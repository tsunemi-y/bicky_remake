// 対象日の予約時間表示
$('.day-ok').click(function() {
    $avaTime = $('#jsAvaTime');
    const date = $(this).data('date');
    $requestedAvaDate = $('#jsRequestedAvaDate');
    $requestedAvaDate.val(date);
    const timesPerTargetDate = avaTimes[date];
    for (i = 0; i < timesPerTargetDate.length; i++) {
        $avaTime.append(`<button class="btn mb-3 ava-time">${timesPerTargetDate[i]}</button>`);
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
    const avaTime = $(this).text();
    $requestedAvaTime = $('#jsRequestedAvaTime');
    $requestedAvaTime.val(avaTime);
});


