function  CustomPreload() {

    CustomPreload.prototype.show = function (elementId = null) {
        var element = elementId ? "#" + elementId : 'body';
        $(element).append('<div class="contenier-loading" style="background : rgba(0, 0, 0, 0.3) !important;"> <div class="signal"></div ></div>');

    };
    
    CustomPreload.prototype.hide = function (elementId = null) {
        setTimeout(function () {
            var element = elementId ? "#" + elementId : 'body';
            $(element).find('.contenier-loading').detach();
        }, 100);
        
    }
}


var CustomPreload = new CustomPreload();

window.onload = function () {
    CustomPreload.hide();
};