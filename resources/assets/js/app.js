/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };

    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//
//window.name = 'fXD';
//window.onload = ()=>
//{
//    VK.init(function () {
//        VK.callMethod("showInstallBox");
//    }, function () {
//        // API initialization failed
//        // Can reload page here
//    }, '5.68');
//}


$(function (CKEDITOR) {
    if ($('#user_create_news').length) {
        $('input[name="is_link"]').on('change', function (e) {
            toggle_source(this);
        });
        $radios = $('input[name="is_link"]');
        for (var i = 0; i < $radios.length; i++) {
            if ($radios[i].checked)
                toggle_source($radios[i]);
        }
        function toggle_source(el) {
            var $block_full = $('#content');
            //var $full = $('#content textarea[name="content_full"]');
            var $block_link = $('#content_link_container');
            if (el.value == 1) {
                $block_full.css('display', 'none');
                //$full.removeAttr('required');
                $block_link.css('display', '');
            } else {
                $block_full.css('display', '');
                ///$full.attr('required', 'required');
                $block_link.css('display', 'none');
            }
        }

        CKEDITOR.replace('content_full');
    }
}(CKEDITOR));