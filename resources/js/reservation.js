$(function(){
    const $yesBtnLink = $('#firstCheckModal').find('#js-yesBtn');
    initUrl = $yesBtnLink.attr('href');
});

// 対象日の予約時間表示
$('.day-ok').click(function() {
    const day = $(this).data('day');
    const $dayStatus = $('.' + day);
    const $timeStatus = $('.time-status')

    $timeStatus.each((index, elm) => {
        if ($(elm).hasClass('show')){
            $(elm).removeClass('show');
            $(elm).addClass('hide');
        }
    });

    $dayStatus.removeClass('hide');
    $dayStatus.addClass('show');
});

$('.time-ok').click(function() {
    const $yesBtnLink = $('#js-yesBtn');
    const $noBtnLink = $('#js-noBtn');
    setQueryStr($(this), $yesBtnLink);
    setQueryStr($(this), $noBtnLink);
    $('#firstCheckModal').modal();
});

$('#js-yesBtn').click(function() {
    replaceQueryStr('yes', $(this), 'modalBtn=');
});

// クエリストリングセット
function setQueryStr(targetElm, modalBtn) {
    modalBtn.attr('href', initUrl);
    replaceQueryStr(targetElm.data('target_date'), modalBtn, 'targetDate=');
    replaceQueryStr(targetElm.data('target_time'), modalBtn, 'targetTime=');
}

// クエリストリング置き換え
function replaceQueryStr(value, elm, key) {
    const url = elm.attr('href');
    const afterLink = url.replace(key, key + value);
    elm.attr('href', afterLink);
}
