/*!
 * PreviewUploadImages - jQuery plugin
 * Create By: Demésio Oliveira
 * Version: 1.0.5
 */

(function($){
    $.fn.previewUploadImages = function(){
        var self = this;

        var buttonImages = $('<button class="btn btn-block btn-primary" style="margin-bottom: 4px" ><i class="fa fa-cloud-upload"></i>&nbsp;Selecionar Imagens&hellip;</button>');
        buttonImages.on("click", function onClick(event) {
            event.stopPropagation();
            event.preventDefault();
            self.click();
        });

        var spaceWell = $('<div class="preview-img" ></div>');
        spaceWell.insertAfter(this);
        buttonImages.insertAfter(this);

        var previewImages = function(){
            spaceWell.empty();
            if (this.files) $.each(this.files, function(i, file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                }

                var reader = new FileReader();

                $(reader).on("load", function() {
                    spaceWell.append($("<div/>", {class:'box-img-list'}).append($("<img/>", {src:this.result, class:'img-box'})));
                });

                reader.readAsDataURL(file);

            });
        };

        this.on("change", previewImages);
        $(this).hide();
    }

})( jQuery );