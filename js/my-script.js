jQuery(document).ready( function( $ ) {
    var fld='';
    $('#upload_image_button_1,#upload_image_button_2').click(function() {
        var id=this.id.replace('button_','');
        fld=id;
        formfield = $('#'+id).attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

    window.send_to_editor = function(html) {

        imgurl = $('img',html).attr('src');
        $('#'+fld).val(imgurl);
        tb_remove();
    }

});