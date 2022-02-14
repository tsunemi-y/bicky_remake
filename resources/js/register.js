
// 表示・非表示制御対象要素リストを定義
// ※兄弟児がいる場合のみ入力する項目が対象
showedOrHidedTargetElementList = [
    $('#age2'),
    $('#gender2'),
    $('#diagnosis2'),
];

$(function() {

    // フラッシュメッセージ表示
    if (isRegistration) {
        $('#registration').modal();
    }

    showOrHideTargetElementList($('#childName2').val(), showedOrHidedTargetElementList);
});

$('#childName2').change(function() {
    showOrHideTargetElementList($(this).val(), showedOrHidedTargetElementList);
});

// 発火要素値の有無により、対象要素リストの表示・非表示を制御
function showOrHideTargetElementList(targetEventElementVal, targetElementList) {
    if (targetEventElementVal) {
        for (let i = 0; i < targetElementList.length; i++) {
            targetElementList[i].removeClass('d-none')
        }
    } else {
        for (let i = 0; i < targetElementList.length; i++) {
            targetElementList[i].addClass('d-none')
        }
    }
}