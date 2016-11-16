/**
 * Created by Administrator on 10/22/2015.
 */
$(function(){
    var buttons = $('.action-buttons');
    buttons.on('click', 'button', function(){
        buttons.children('input').val($(this).data('submit'));
    });
});