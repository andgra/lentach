
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.name = 'fXD';
window.onload = ()=>
{
    VK.init(function () {
        VK.callMethod("showInstallBox");
    }, function () {
        // API initialization failed
        // Can reload page here
    }, '5.68');
}