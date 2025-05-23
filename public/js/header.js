$("#js-menu").click(function() {
    var menuLine = $(this).children('span');
    menuLine.toggleClass("is-active");

    var menuInner = $('#js-menu-inner');
    menuInner.toggleClass("is-active");
});
