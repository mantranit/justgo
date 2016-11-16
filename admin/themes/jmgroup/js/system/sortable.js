/**
 * Created by Administrator on 10/22/2015.
 */
$(function(){
    $('.table tbody').sortable({
        update: function( event, ui ) {
            var url = $('.system').data('url');
            var idList = '';
            $('.table tbody tr').each(function(i, e){
                if(i === 0) {
                    idList += $(this).data('key');
                }
                else {
                    idList += ',' + $(this).data('key');
                }
            });
            $.get(url, 'idList=' + idList);
        }
    });
});