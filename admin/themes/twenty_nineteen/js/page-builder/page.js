/**
 * Created by Jimmy on 6/18/2015.
 */
$(function(){
    var buttons = $('.action-buttons');
    buttons.on('click', 'button', function(){
        buttons.children('input').val($(this).data('submit'));
    });

    $('#content-using_page_builder').on('click', 'input[type="radio"]', function(){
        $('.radio-group').hide();
        $('.radio-group.radio-item-'+$(this).val()).show();
    });

    $('#action-form').on('submit', function(){
        var images = $('input[name="Content[image_id]"]');
        if(images.length > 0) {
            var flag = true;
            images.each(function () {
                if ($(this).prop('checked')) {
                    flag = false;
                    return;
                }
            });
            if (flag) {
                $(images.get(0)).prop('checked', 'checked');
            }
        }
    });
});