
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
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
$('input[name="is_link"]').on('change',function(e) {
    var $link=$('#content_link');
    var $full=$('#content');
    if(this.value==1) {
        $full.css('display','none');
        //$full.attr('name','');
        $link.css('display','');
        //$link.attr('name','content');
    } else {
        //$full.attr('name','content');
        $full.css('display','');
        //$link.attr('name','');
        $link.css('display','none');
    }
});