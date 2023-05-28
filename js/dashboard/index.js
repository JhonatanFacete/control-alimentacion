$(function () {
    'use strict';

    const FONT_COLOR = Sing.colors['gray-400'];

    let debouncedTimeout = 0;



   

    function pageLoad() {
        $('.widget').widgster();
        $('.selectpicker').selectpicker();

    }

    pageLoad();
    SingApp.onPageLoad(pageLoad);
});

